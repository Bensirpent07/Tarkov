<?php

namespace App\Models;

use CodeIgniter\Model;

class Ammo extends Model
{
    public function getCalibers(){
        //Gather all ammo and group them by caliber
        $builder = $this->db->table('ammo');
        $query = $builder->groupBy('caliber')->get();

        //Assort into an array of only calibers
        $result = $query->getResult();
        $calibers = array();
        foreach($result as $object){
            array_push($calibers, $object->caliber);
        }

        return $calibers;
    }

    public function get_ammo_list(){
        $builder = $this->db->table('ammo');
        $query = $builder->get();
        $result = $query->getResult();
        foreach($result as $object){
            settype($object->damage, 'int');
            settype($object->pen, 'int');
            settype($object->frag, 'float');
            settype($object->ricochet, 'float');
            settype($object->speed, 'int');
        }

        return $result;
    }
}