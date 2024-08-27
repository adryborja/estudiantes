<?php

class Estudiante extends DB {
    public $id;
    public $nombre;
    public $apellido;
    public $edad;
    public $email;
    public $cedula;

    public static function all() {
        $db = new DB();
        $prepare = $db->prepare("SELECT * FROM estudiante");
        $prepare->execute();

        return $prepare->fetchAll(PDO::FETCH_CLASS, Estudiante::class);
    }

    public static function find($id) {
        $db = new DB();
        $prepare = $db->prepare("SELECT * FROM estudiante WHERE id=:id");
        $prepare->execute([":id" => $id]);

        return $prepare->fetchObject(Estudiante::class);
    }

    public function save() {
        $params = [
            ":nombre" => $this->nombre, 
            ":apellido" => $this->apellido,
            ":edad" => $this->edad, 
            ":email" => $this->email,
            ":cedula" => $this->cedula
        ];

        if (empty($this->id)) {
            $prepare = $this->prepare("INSERT INTO estudiante(nombre, apellido, edad, email, cedula) VALUES (:nombre, :apellido, :edad, :email, :cedula)");
            $prepare->execute($params);

            $prepare2 = $this->prepare("SELECT MAX(id) id FROM estudiante");
            $prepare2->execute();
            $this->id = $prepare2->fetch(PDO::FETCH_ASSOC)["id"];
        } else {
            $params[":id"] = $this->id;
            $prepare = $this->prepare("UPDATE estudiante SET nombre=:nombre, apellido=:apellido, edad=:edad, email=:email, cedula=:cedula WHERE id=:id");
            $prepare->execute($params);
        }
    }

    public function remove() {
        $prepare = $this->prepare("DELETE FROM estudiante WHERE id=:id");
        $prepare->execute([":id" => $this->id]);
    }
}
?>