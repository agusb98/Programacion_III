<?php
    class Archivo
    {
        //VALIDO EXISTENCIA DEL ARCHIVO

        public function FileExists(){
            return file_exists($_FILES["archivo"]["tmp_name"]);
        }

        //OBTENGO NOMBRE TEMPORAL DEL ARCHIVO

        public function GetTmpName()
        {
            if(Archivo::FileExists()){
                return $_FILES["archivo"]["tmp_name"];
            }
        }

        //OBTENGO ARRAY DE STRING CON EL NOMBRE DEL ARCHIVO

        public function GetName()
        {
            if(Archivo::FileExists()){
                return explode(".", $_FILES["archivo"]["name"]);
            }
        }       
        
        //OBTENGO TAMANIO DEL ARCHIVO

        public function GetSize()
        {
            if(Archivo::FileExists()){
                return $_FILES["archivo"]["size"];
            }
        }     

        //OBTENGO RUTA DEL ARCHIVO

        public function GetPath()
        {
            if(Archivo::FileExists()){
                return "img/" . Archivo::GetNameUnico();
            }
        }

        //CAMBIA NOMBRE DEL ARCHIVO POR UNICO 

        public function GetNameUnico()
        {
            if(Archivo::FileExists())
            {
                $name = Archivo::GetName();
                $aleatorio = rand(1, 999);

                return $name[0]. "_" . $aleatorio . "." . $name[1];
            }
        }

        //VERIFICO SI EL ARCHIVO SE EXCEDE DEL TAMANIO PASADO POR PARAMETRO

        public function TamanioExcedido($bites) : bool
        { 
            if(Archivo::FileExists() && Archivo::GetSize() > $bites){
                return TRUE;
            }

            return FALSE;
        }

        /**
         * VERIFICO SI ES UNA IMAGEN O NO
         * OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
         * IMAGEN, RETORNA FALSE
         */

        public function EsImagen() : bool
        { 
            $type = Archivo::GetName()[1];

            if($type != null)
            {
                // ES UNA IMAGEN, SOLO PERMITO CIERTAS EXTENSIONES
                if($type != "jpg" && $type != "jpeg" && $type != "gif" && $type != "png") 
                {
                    echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
                }
                return true;
            }
            return false;
        }

        /**
         * MUEVO LEL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
         */

        public function Mover() : bool
        { 
            if(Archivo::EsImagen())
            {
                $origen = Archivo::GetTmpName();
                $destino = Archivo::GetPath();
    
                return move_uploaded_file($origen, $destino);
            }
            
            return false;
        }

        /**
         * BORRO EL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
         */

        public function Borrar() : bool
        { 
            return false;
        }
    }
?>