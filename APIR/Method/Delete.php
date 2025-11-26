<?php
    use Config\Conexion as Conexion;
    $Conexion = new Conexion();
    $Conexion = $Conexion->getConexion();

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $table = isset($_POST['table']) ? $_POST['table'] : '';

    if(empty($id)) {
        $json = array(
            'message' => 'Id no proporcionado',
            'success' => false
        );  

        echo json_encode($json);
        http_response_code(200);
        exit;
    }

    if(empty($table)){
        $json = array (
            'message' => 'Tabla no proporcionada',
            'success' => false
        );

        echo json_encode($json);
        http_response_code(200);
        exit;
    }

    $sql = "call SP_Delete$table (:id);";
    $stmt = $Conexion->prepare($sql);
    $stmt ->bindParam(':id', $id);
    if($stmt->execute()){
        $json = array(
            'message' => "Registro eliminado correctamente!",
            'success' => true

        );

        echo json_encode($json);
        http_response_code(200);
    } else {
        $json = array(
            'message' => "Error al eliminar el registro de la tabla $table!",
            'success' => false
        );

        echo json_encode($json),
        http_response_code(200);
    }

?>