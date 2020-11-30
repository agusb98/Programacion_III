<?php
include_once "./clases/usuario.php";
include_once "./clases/materia.php";
include_once "./clases/profesor.php";
include_once "./clases/asignacion.php";

require_once './vendor/autoload.php';

$request_method = $_SERVER['REQUEST_METHOD'] ?? '';
$operator = $_SERVER['PATH_INFO'] ?? '';

if($request_method == 'POST'){
    switch($operator){
        case '/usuario':
            echo "Registrar a un cliente con email, clave y foto y guardarlo en el archivo users.xxx. Darle un nombre único a la imagen";
            $obj = new Usuario($_POST['email'] ?? "", $_POST['clave'] ?? "", $_FILES["foto"]['name'] ?? "");

            if($obj->Validation()){
                if($obj->SaveAsFile()) 
                {
                    $obj->SetNamePhoto();   //Seteo el nombre de la foto a uno unico, en caso de que haya
                    Usuario::MovePhoto($_FILES["foto"]["tmp_name"] ?? "", "./img/" . $obj->_foto);
                    echo "<br>Se ha guardado con exito.<br>" . $obj->ToJson() . "<br>"; 
                }
                else{
                    echo "<br>No se pudo guardar en el archivo";
                }
            } 
            else{
                echo "<br>Email Repetido o Clave debil";
            }
            break;
        case '/login':
            echo "Recibe email y clave y si son correctos devuelve un JWT, de lo contrario informar lo sucedido." . "<br>";
            $obj = new Usuario($_POST['email'] ?? "", $_POST['clave'] ?? "");
            $obj = $obj->GetUser();

            if($obj){
                echo $obj->ToJson();
            }
            else{
                echo "Inexistente";
            }
            break;
        case '/materia':
            $obj = new Materia($_POST['nombre'] ?? "", $_POST['cuatrimestre'] ?? "");

            if($obj->Validation()){
                if($obj->SaveAsFile()){
                    echo "Se ha guardado con exito.<br>" . $obj->ToJson() . "<br>";
                }
                else{
                    echo "<br>No se pudo guardar en el archivo";
                }
            }
            else{
                echo "Dato/s Incorrecto/s";
            }
            break;
            case '/profesor':
                $obj = new Profesor($_POST['nombre'] ?? "", $_POST['legajo'] ?? 0);
    
                if($obj->Validation()){
                    if($obj->SaveAsFile()){
                        echo "Se ha guardado con exito.<br>" . $obj->ToJson() . "<br>";
                    }
                    else{
                        echo "<br>No se pudo guardar en el archivo";
                    }
                }
                else{
                    echo "Dato/s Incorrecto/s : Legajo Incorrecto o Repetido";
                }
                break;
                case '/asignacion':
                    $obj = new Asignacion($_POST['legajo'] ?? "", $_POST['id'] ?? "", $_POST['turno'] ?? "");
        
                    if($obj->Validation()){
                        if($obj->SaveAsFile()){
                            echo "Se ha guardado con exito.<br>" . $obj->ToJson() . "<br>";
                        }
                        else{
                            echo "<br>No se pudo guardar en el archivo";
                        }
                    }
                    else{
                        echo "Dato/s Incorrecto/s";
                    }
                    break;
        case '/usuario/email':
            echo " Recibe una imagen y se la asigna al Usuario indicado. Guardar la imagen anterior en la carpeta backup.";
            $name = $_FILES["foto"]['name'] ?? "";
            $obj = new Usuario($_POST['email'] ?? "", $_POST['clave'] ?? "", $name);
            $obj = $obj->GetUser();

            if($obj != null){
                if(Usuario::MovePhoto($_FILES["foto"]['tmp_name'] ?? "", "./img/backup/" . $name)){
                    if($obj->SaveAsFile()){
                        echo "<br>Se ha guardado con exito.<br>" . $obj->ToJson() . "<br>";
                    }
                    else{
                        echo "<br>No se pudo guardar en el archivo";
                    }
                }
            }
            else{
                echo "<br>Inexistente";
            }
            break;
        break;
        default:
            echo "No se encuentra operacion de este tipo";
    }
}
else if ($request_method == 'GET'){
    switch($operator){
        case '/usuario':
            var_dump(Usuario::GetAll());
            break;
        case '/materia':
            var_dump(Materia::GetAll());
            break;
        case '/profesor':
            var_dump(Profesor::GetAll());
            break;
        case '/asignacion':
            echo Asignacion::MateriasPorProfesor();
            break;
        default:
            echo "No se encuentra operacion de este tipo";

    }
    
}else{
    echo "405 method not allowed";
}
?>