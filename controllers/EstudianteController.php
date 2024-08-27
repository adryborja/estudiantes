<?php

class EstudianteController {
    public function index() {
        $estudiantes = Estudiante::all();
        view('index', ['estudiantes' => $estudiantes]);
    }

    public function crear(){
        echo "estamos en crear";
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'));
        $estudiante = new Estudiante();
        $estudiante->nombre = $data->nombre;
        $estudiante->apellido = $data->apellido;
        $estudiante->edad = $data->edad;
        $estudiante->email = $data->email;
        $estudiante->cedula = $data->cedula;
        $estudiante->save();

        echo json_encode($estudiante);
    }

    public function update() {
        $data = json_decode(file_get_contents('php://input'));
        $estudiante = Estudiante::find($data->id);
        $estudiante->nombre = $data->nombre;
        $estudiante->apellido = $data->apellido;
        $estudiante->edad = $data->edad;
        $estudiante->email = $data->email;
        $estudiante->cedula = $data->cedula;
        $estudiante->save();

        echo json_encode($estudiante);
    }

    public function delete($id) {
        try {
            $estudiante = Estudiante::find($id);
            $estudiante->remove();

            echo json_encode(['status' => true]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false]);
        }
    }

    public function find($id) {
        $estudiante = Estudiante::find($id);

        echo json_encode($estudiante);
    }
}
?>