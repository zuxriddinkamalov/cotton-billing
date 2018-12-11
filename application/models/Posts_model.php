<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model 
{
  public function get_all_data($table, $offset = false, $limit = false, $filter = []) {
    if (!$offset)
      return $this->db->get($table)->result();
    if (!$limit)
      $limit = 100;
    if (@$filter['name'])
      $this->db->like('name', $filter['name']);
    return $this->db->get($table, $limit, $limit * ($offset - 1))->result();
  }

  public function get_data_by_id($table, $id) {
    $this->db->where('id', $id);
    return $this->db->get($table)->result()[0];
  }

  public function insert_data($table, $args) {
    return $this->db->insert($table, $args);
  }

  public function update_data($table, $id, $args) {
    $this->db->where('id', $id);
    $this->db->set($args);
    return $this->db->update($table);
  }

  public function delete_data($table, $id) {
    return $this->db->delete($table, array('id' => $id));
  }

  /*================================*/
  /*        Dislocation             */
  /*================================*/
  public function check_dublicate($table, $args) {
    $data = $this->db->get_where($table, $args)->result();
    if ($data) {
      return true;
    }
    return false;
  }

  public function get_all_dislocation($offset = false, $limit = false, $filter = []) {
    $this->db->select('*');
    $this->db->from('factory');
    $this->db->join('dislocation', 'dislocation.factory_id = factory.id', 'LEFT');
    if (!$offset)
      return $this->db->get()->result();
    if (!$limit)
      $limit = 100;
    if ($filter['factory_id'])
        $this->db->where('dislocation.factory_id', $filter['factory_id']);
    if ($filter['start'])
        $this->db->where('dislocation.date >=', $filter['start']);
    if ($filter['end'])
        $this->db->where('dislocation.date <=', $filter['end']);
    $this->db->order_by('dislocation.date', 'DESC');
    $this->db->limit($limit, $limit * ($offset - 1));
    $this->db->having('dislocation.factory_id = factory.id');
    return $this->db->get()->result();
  }

  /*================================*/
  /*             Staple             */
  /*================================*/
  public function get_all_staples($offset = false, $limit = false, $filter = []){
    if (!$offset)
        $offset = 1;
    if (!$limit)
      $limit = 1000000000;
    if (!$filter['one_filter']) {
      $this->db->select('*');
      $this->db->from('factory');
      $this->db->join('staple', 'staple.factory_id = factory.id', 'LEFT');
      if ($filter['factory_id'])
        $this->db->where('staple.factory_id', $filter['factory_id']);
      if ($filter['start'])
        $this->db->where('staple.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('staple.date <=', $filter['end']);
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->order_by('staple.date', 'DESC');
      $this->db->having('staple.factory_id = factory.id');
      return $this->db->get()->result();
    } else {
      $this->db->select('staple.id, staple.factory_id, sum(staple.weight) as weight, sum(staple.summ) as summ, sum(staple.pay_summ) as pay_summ, sum(staple.by_bank) as by_bank, sum(staple.by_tax) as by_tax, sum(staple.by_self_counting) as by_self_counting, currency_id, staple.date, factory.id, factory.name, factory.phone, factory.info, factory.address');
      $this->db->from('staple');
      $this->db->join('factory', 'staple.factory_id = factory.id', 'INNER');
      if ($filter['factory_id'])
        $this->db->where('staple.factory_id', $filter['factory_id']);
      if ($filter['start'])
        $this->db->where('staple.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('staple.date <=', $filter['end']);
      $this->db->order_by('staple.date', 'DESC');
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->group_by(array('staple.factory_id', 'staple.currency_id'));
      $this->db->having('staple.factory_id = factory.id');
      return $this->db->get()->result();
    }
  }

  public function staple_deb($id, $currency_id, $month = false) {
    if ($month)
      $this->db->where('staple.date <', $month);    
    $this->db->select('(sum(staple.summ) - sum(staple.pay_summ)) as value');
    $this->db->where('staple.factory_id', $id);
    $this->db->where('staple.currency_id', $currency_id);
    return $this->db->get('staple')->result()[0];
  }

  /*================================*/
  /*               Corn             */
  /*================================*/
  public function get_all_corns($offset = false, $limit = false, $filter = []){
    if (!$offset)
        $offset = 1;
    if (!$limit)
      $limit = 1000000000;
    if (!$filter['one_filter']) {
      $this->db->select('*');
      $this->db->from('factory');
      $this->db->join('corn', 'corn.factory_id = factory.id', 'LEFT');
      if ($filter['factory_id'])
        $this->db->where('corn.factory_id', $filter['factory_id']);
      if ($filter['start'])
        $this->db->where('corn.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('corn.date <=', $filter['end']);
      $this->db->order_by('corn.date', 'DESC');
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->having('corn.factory_id = factory.id');
      return $this->db->get()->result();
    } else {
      $this->db->select('corn.id, corn.factory_id, sum(corn.weight) as weight, sum(corn.summ) as summ, sum(corn.pay_summ) as pay_summ, sum(corn.by_bank) as by_bank, sum(corn.by_tax) as by_tax, sum(corn.by_self_counting) as by_self_counting, currency_id, corn.date, factory.id, factory.name, factory.phone, factory.info, factory.address');
      $this->db->from('corn');
      $this->db->join('factory', 'corn.factory_id = factory.id', 'INNER');
      if ($filter['factory_id'])
        $this->db->where('corn.factory_id', $filter['factory_id']);
      if ($filter['start'])
        $this->db->where('corn.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('corn.date <=', $filter['end']);
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->order_by('corn.date', 'DESC');
      $this->db->group_by(array('corn.factory_id', 'corn.currency_id'));
      $this->db->having('corn.factory_id = factory.id');
      return $this->db->get()->result();
    }
  }
  public function corn_dislocation($id, $month) {
    $this->db->select('*');
    $month = new DateTime($month);
    $this->db->where('date', $month->format('Y-m-01'));
    $this->db->where('factory_id', $id);
    return $this->db->get('dislocation')->result();
  }
  public function corn_deb($id, $currency_id, $month = false) {
    if ($month)
      $this->db->where('corn.date <', $month);    
    $this->db->select('(sum(corn.summ) - sum(corn.pay_summ)) as value');
    $this->db->where('corn.factory_id', $id);
    $this->db->where('corn.currency_id', $currency_id);
    return $this->db->get('corn')->result()[0];
  }

  /*================================*/
  /*               Corn             */
  /*================================*/
  public function get_all_cottons($offset = false, $limit = false, $filter = []){
    if (!$offset)
        $offset = 1;
    if (!$limit)
      $limit = 1000000000;
    if (!$filter['one_filter']) {
      $this->db->select('*');
      $this->db->from('factory');
      $this->db->join('cotton', 'cotton.factory_id = factory.id', 'LEFT');
      if ($filter['factory_id'])
        $this->db->where('cotton.factory_id', $filter['factory_id']);
      if ($filter['start'])
        $this->db->where('cotton.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('cotton.date <=', $filter['end']);
      $this->db->order_by('cotton.date', 'DESC');
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->having('cotton.factory_id = factory.id');
      return $this->db->get()->result();
    } else {
      $this->db->select('cotton.id, cotton.factory_id, sum(cotton.weight) as weight, sum(cotton.summ) as summ, sum(cotton.pay_summ) as pay_summ, sum(cotton.by_bank) as by_bank, sum(cotton.by_tax) as by_tax, sum(cotton.by_self_counting) as by_self_counting, currency_id, cotton.date, factory.id, factory.name, factory.phone, factory.info, factory.address');
      $this->db->from('cotton');
      $this->db->join('factory', 'cotton.factory_id = factory.id', 'INNER');
      if ($filter['factory_id'])
        $this->db->where('cotton.factory_id', $filter['factory_id']);
      if ($filter['start'])
        $this->db->where('cotton.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('cotton.date <=', $filter['end']);
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->order_by('cotton.date', 'DESC');
      $this->db->group_by(array('cotton.factory_id', 'cotton.currency_id'));
      $this->db->having('cotton.factory_id = factory.id');
      return $this->db->get()->result();
    }
  }

  public function cotton_deb($id, $currency_id, $month = false) {
    if ($month)
      $this->db->where('cotton.date <', $month);    
    $this->db->select('(sum(cotton.summ) - sum(cotton.pay_summ)) as value');
    $this->db->where('cotton.factory_id', $id);
    $this->db->where('cotton.currency_id', $currency_id);
    return $this->db->get('cotton')->result()[0];
  }

  /*================================*/
  /*               Charges          */
  /*================================*/
  public function get_all_charges($offset = false, $limit = false, $filter = []){
    if (!$offset)
        $offset = 1;
    if (!$limit)
      $limit = 1000000000;
    if (!$filter['one_filter']) {
      $this->db->select('*');
      $this->db->from('charges_types');
      $this->db->join('charges', 'charges.charges_type_id = charges_types.id', 'LEFT');
      if ($filter['charges_type_id'])
        $this->db->where('charges.charges_type_id', $filter['charges_type_id']);
      if ($filter['start'])
        $this->db->where('charges.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('charges.date <=', $filter['end']);
      $this->db->order_by('charges.date', 'DESC');
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->having('charges.charges_type_id = charges_types.id');
      return $this->db->get()->result();
    } else {
      $this->db->select('charges.id, charges.currency_id, charges.charges_type_id, charges.date, sum(charges.output_summ) as output_summ, charges_types.id, charges_types.name');
      $this->db->from('charges');
      $this->db->join('charges_types', 'charges.charges_type_id = charges_types.id', 'INNER');
      if ($filter['charges_type_id'])
        $this->db->where('charges.charges_type_id', $filter['charges_type_id']);
      if ($filter['start'])
        $this->db->where('charges.date >=', $filter['start']);
      if ($filter['end'])
        $this->db->where('charges.date <=', $filter['end']);
      $this->db->limit($limit, $limit * ($offset - 1));
      $this->db->order_by('charges.date', 'DESC');
      $this->db->group_by(array('charges.charges_type_id', 'charges.currency_id'));
      $this->db->having('charges.charges_type_id = charges_types.id');
      return $this->db->get()->result();
    }
  }
  
}