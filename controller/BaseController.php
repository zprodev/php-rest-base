<?php

class BaseController {
    public function receiveRequest() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $this->post();
                    break;
                case 'GET':
                    $this->get();
                    break;
                case 'PUT':
                    $this->put();
                    break;
                case 'DELETE':
                    $this->delete();
                    break;
                default:
                    break;
            }
        } catch (Exception $e) {
            $this->failure(['message' => DEBUG ? $e->getMessage() : 'Internal Server Error']);
        }
        $this->failure(null, 405);
    }

    protected function getPDO() {
        static $pdo;
    
        if (!isset($pdo)) {
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
            $pdo = new PDO( $dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return $pdo;
    }
    
    protected function post(){}
    protected function get(){}
    protected function put(){}
    protected function delete(){}

    protected function success($data = null){
        header("Content-Type: application/json; charset=utf-8", true, 200);
        if($data){
            echo json_encode($data);
        }
        exit;
    }

    protected function failure($data = null, $code = 500){
        header("Content-Type: application/json; charset=utf-8", true, $code);
        if($data){
            echo json_encode($data);
        }
        exit;
    }
}

