<?php
defined('BASEPATH') or exit('No direct script access allowed');

class License_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tblmulti_pipeline_license';
    }

    public function get_active_license()
    {
        return $this->db->where('is_active', 1)->get($this->table)->row();
    }

    public function set_license($license_key)
    {
        $this->db->where('is_active', 1)->update($this->table, ['is_active' => 0]);
        
        return $this->db->insert($this->table, [
            'license_key' => $license_key,
            'is_active' => 1
        ]);
    }

    public function validate_license($license_key)
    {
        // Implemente sua lógica de validação aqui
        // Por exemplo, você pode verificar se a chave tem um formato específico
        return (bool) preg_match('/^MP-[A-Z0-9]{16}$/', $license_key);
    }

    public function create_license_table()
    {
        $this->load->dbforge();

        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'license_key' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ),
            'is_active' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => FALSE,
                'default' => date('Y-m-d H:i:s')
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        
        // Adicione logs para depuração
        log_activity('Tentando criar tabela de licença: ' . $this->table);
        
        $result = $this->dbforge->create_table($this->table, TRUE);
        
        // Adicione mais logs para depuração
        log_activity('Resultado da criação da tabela: ' . ($result ? 'Sucesso' : 'Falha'));
        
        return $result;
    }
}