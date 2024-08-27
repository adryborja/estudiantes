<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Estudiantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <style>
    body {
      background-color: #f7f9fc;
      font-family: 'Arial', sans-serif;
    }

    .container {
      margin-top: 50px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-weight: 700;
      color: #333;
    }

    .btn-success {
      background-color: #28a745;
      border-color: #28a745;
      transition: background-color 0.3s ease;
    }

    .btn-success:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #f2f2f2;
    }

    .table th {
      color: #fff;
      background-color: #007bff;
      border-bottom: 2px solid #dee2e6;
    }

    .table td, .table th {
      text-align: center;
      vertical-align: middle;
    }

    .btn-warning {
      background-color: #ffc107;
      border-color: #ffc107;
      color: #fff;
      transition: background-color 0.3s ease;
    }

    .btn-warning:hover {
      background-color: #e0a800;
      border-color: #d39e00;
    }

    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
      color: #fff;
      transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }

    .modal-header {
      background-color: #007bff;
      color: #fff;
    }

    .modal-content {
      border-radius: 10px;
    }

    .form-floating .form-control {
      border-radius: 5px;
      border: 1px solid #ced4da;
    }

    .form-floating label {
      color: #495057;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="mt-5">Lista de Estudiantes</h1>
    <button class="btn btn-success mb-3">Agregar Estudiante</button>
    <table class="table table-striped mt-4" id="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Edad</th>
          <th>Email</th>
          <th>Cédula</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($estudiantes as $estudiante) : ?>
          <tr data-id="<?php echo $estudiante->id; ?>">
            <td><?php echo $estudiante->id; ?></td>
            <td><?php echo $estudiante->nombre; ?></td>
            <td><?php echo $estudiante->apellido; ?></td>
            <td><?php echo $estudiante->edad; ?></td>
            <td><?php echo $estudiante->email; ?></td>
            <td><?php echo $estudiante->cedula; ?></td>
            <td>
              <button class="btn btn-warning btnEditar">Editar</button>
              <button class="btn btn-danger btnEliminar">Eliminar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="estudianteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Estudiante</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input type="text" id="nombre" class="form-control" placeholder="Nombre">
            <label for="nombre">Nombre</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" id="apellido" class="form-control" placeholder="Apellido">
            <label for="apellido">Apellido</label>
          </div>
          <div class="form-floating mb-3">
            <input type="number" id="edad" class="form-control" placeholder="Edad">
            <label for="edad">Edad</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" id="email" class="form-control" placeholder="Email">
            <label for="email">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" id="cedula" class="form-control" placeholder="Cédula">
            <label for="cedula">Cédula</label>
          </div>
          <input type="hidden" id="identificador" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary btn-guardar">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let myModal = new bootstrap.Modal(document.getElementById('estudianteModal'));

    const fetchEstudiante = (event) => {
      let id = event.target.parentNode.parentNode.dataset.id;
      axios.get(`http://localhost/app-mvc/estudiante/find/${id}`).then((res) => {
        let info = res.data;
        document.querySelector("#exampleModalLabel").innerHTML = "Editar Estudiante";
        document.querySelector('#nombre').value = info.nombre;
        document.querySelector('#apellido').value = info.apellido;
        document.querySelector('#edad').value = info.edad;
        document.querySelector('#email').value = info.email;
        document.querySelector('#cedula').value = info.cedula;
        document.querySelector('#identificador').value = id;
        myModal.show();
      })
    }

    const deleteEstudiante = (event) => {
      let id = event.target.parentNode.parentNode.dataset.id;
      axios.delete(`http://localhost/app-mvc/estudiante/delete/${id}`).then((res) => {
        let info = res.data;
        if (info.status) {
          document.querySelector(`tr[data-id="${id}"]`).remove();
        }
      })
    }

    document.querySelector('.btn.btn-success')
      .addEventListener('click', () => {
        document.querySelector("#exampleModalLabel").innerHTML = "Crear Estudiante";
        document.querySelector('#nombre').value = "";
        document.querySelector('#apellido').value = "";
        document.querySelector('#edad').value = "";
        document.querySelector('#email').value = "";
        document.querySelector('#cedula').value = "";
        document.querySelector('#identificador').value = "";
        myModal.show();
      });

    document.querySelector('.btn-guardar')
      .addEventListener('click', () => {
        let id = document.querySelector('#identificador').value;
        let nombre = document.querySelector('#nombre').value;
        let apellido = document.querySelector('#apellido').value;
        let edad = document.querySelector('#edad').value;
        let email = document.querySelector('#email').value;
        let cedula = document.querySelector('#cedula').value;
        axios.post(`http://localhost/app-mvc/estudiante/${id == "" ? 'create' : 'update'}`, {
            id,
            nombre,
            apellido,
            edad,
            email,
            cedula
          })
          .then((r) => {
            let info = r.data;
            if (id == "") {
              // Agregar
              let tr = document.createElement("tr");
              tr.setAttribute('data-id', info.id);
              tr.innerHTML = `<td>${info.id}</td>
                              <td>${info.nombre}</td>
                              <td>${info.apellido}</td>
                              <td>${info.edad}</td>
                              <td>${info.email}</td>
                              <td>${info.cedula}</td>
                              <td><button class='btn btn-warning btnEditar'>Editar</button>
                              <button class='btn btn-danger btnEliminar'>Eliminar</button></td>`;
              document.getElementById("table")
                .querySelector("tbody").append(tr);
              tr.querySelector('td:last-child .btnEditar')
                .addEventListener('click', fetchEstudiante);
              tr.querySelector('td:last-child .btnEliminar')
                .addEventListener('click', deleteEstudiante);
            } else {
              // Editar
              let tr = document.querySelector(`tr[data-id="${id}"]`);
              let cols = tr.querySelectorAll("td");
              cols[1].innerText = info.nombre;
              cols[2].innerText = info.apellido;
              cols[3].innerText = info.edad;
              cols[4].innerText = info.email;
              cols[5].innerText = info.cedula;
            }
            myModal.hide();

          })
      })
    let btnsEditar = document.querySelectorAll('.btnEditar');
    let btnsEliminar = document.querySelectorAll('.btnEliminar');
    for (let i = 0; i < btnsEditar.length; i++) {
      btnsEditar[i].addEventListener('click', fetchEstudiante);
      btnsEliminar[i].addEventListener('click', deleteEstudiante);
    }
  </script>
</body>

</html>