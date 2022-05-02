<?php

function deleteD($dir)
{
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) != false) {
            if (($file == ".") || ($file == "..")) continue;
            if (is_dir($dir . '/' . $file))
                deleteD($dir . '/' . $file);
            else
                unlink($dir . '/' . $file);
        }
        closedir($dh);
        rmdir($dir);
    }
}

class datb {
    public $PATH = "datb/database/";

    public function create($database) {
        if (!is_dir($this->PATH . $database)) {
            mkdir($this->PATH . $database);
            file_put_contents($this->PATH . $database . "/value.rf", "");
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function put($database, $var, $value) {
        if (is_dir( $this->PATH . $database)) {
            $old = file_get_contents( $this->PATH . $database . "/value.rf");
            file_put_contents( $this->PATH . $database . "/value.rf"  , "\n" . $var . "=>" . $value . $old);
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function get($database, $var) {
        if (is_dir( $this->PATH . $database)) {
            $dat = file_get_contents( $this->PATH . $database . "/value.rf");
            $dat = explode("\n", $dat); 

            foreach ($dat as $value) {
                if ($value != ""){
                    $value = explode("=>", $value);
                    if ($value[0] == $var) {
                        return $value[1];
                    }
                }
            }
            return FALSE;
        }
        else {
            return FALSE;
        }
    }

    public function getALL($database, $valu="ALL") {
        if (is_dir( $this->PATH . $database)) {
            $dat = file_get_contents( $this->PATH . $database . "/value.rf");
            $dat = explode("\n", $dat);
            $dat_full = [];
            foreach ($dat as $value) {
                if ($value != ""){
                    if ($valu = "ALL") {
                        $value = explode("=>", $value);
                        $dat_full[$value[0]] = $value[1];
                    }
                    else {
                        $value = explode("=>", $value);
                        if ($value[0] == $valu){
                            $dat_full[$value[0]] = $value[1];
                        }
                    }
                }
            }
            # print_r($dat_full);
            return $dat_full;
        }
        else {
            return FALSE;
        }
    }

    public function is($database, $var) {
        if (is_dir( $this->PATH . $database)) {
            $dat = file_get_contents( $this->PATH . $database . "/value.rf");
            $dat = explode("\n", $dat); 

            foreach ($dat as $value) {
                $value = explode("=>", $value);
                if ($value[0] == $var) {
                    return TRUE;
                }
            }
            return FALSE;
        }
        else {
            return FALSE;
        }
    }


    public function removeV($database, $var) {
        if (is_dir( $this->PATH . $database)) {
            $dat = file_get_contents($this->PATH . $database . "/value.rf");
            if ($this->is($database, $var)){
                $fol = $var . "=>" . $this->get($database, $var);
                $dat = str_replace($fol, "", $dat);
                file_put_contents($this->PATH . $database . "/value.rf", $dat);
            }
            return FALSE;
        }
        else {
            return FALSE;
        }
    }

    public function isdat($database) {
        if (is_dir( $this->PATH . $database)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function remove($database) {
        if (is_dir( $this->PATH . $database)) {
            if (deleteD( $this->PATH . $database)){
                return TRUE;
            }
        }
        else {
            return FALSE;
        }
    }

    public function add($database, $var, $new_value) {
        if (is_dir( $this->PATH . $database)) {
            $dat = file_get_contents( $this->PATH . $database . "/value.rf");
            if ($this->is($database, $var)){
                $fol = $var . "=>" . $this->get($database, $var);
                $dat = str_replace($fol, $fol . $new_value, $dat);
                file_put_contents($this->PATH . $database . "/value.rf" , $dat);
                return TRUE;
            }
            return FALSE;
        }
        else {
            return FALSE;
        }
    }
}