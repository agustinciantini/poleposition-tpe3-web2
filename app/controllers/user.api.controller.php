<?php

    require_once './app/models/UserModel.php';
    require_once './app/views/APIView.php';
    require_once './app/libs/jwt.php';

    class UserApiController {
        private $model;
        private $view;

        public function __construct() {
            $this->model = new UserModel();
            $this->view = new APIView();

        }

        public function getToken() {
            // obtengo el username y la contraseña desde el header
            $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
            $auth_header = explode(' ', $auth_header);
            if(count($auth_header) != 2) {
                return $this->view->response("Error en los datos ingresados.", 400);
            }
            if($auth_header[0] != 'Basic') {
                return $this->view->response("Error en los datos ingresados.", 400);
            }
            $user_pass = base64_decode($auth_header[1]);
            $user_pass = explode(':', $user_pass); 
            // Buscamos El usuario en la base por username
            $user = $this->model->getUserByEmail($user_pass[0]);
            
            // Chequeamos la contraseña contra el campo 'pass'
            if($user == null || !password_verify($user_pass[1], $user->pass)) {
                return $this->view->response("Error en los datos ingresados.", 400);
            }
            
            // Generamos el token usando 'usuario_id' y 'username'
            $token = createJWT(array(
                'sub' => $user->usuario_id, // ID de la tabla 'usuarios_id'
                'usuario' => $user->username, // Nombre de usuario para el token
                'role' => 'admin',
                'iat' => time(),
                'exp' => time() + 3600, // Token válido por 1 hora
                'Saludo' => 'Bienvenido a Pole Position.',
            ));
            return $this->view->response($token, 200);
        }
    }