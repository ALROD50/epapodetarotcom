<?php
/**
 * Controller.php
 * @author Lídmo <suporte@lidmo.com.br>
 */

class Controller
{
    protected $fw;
    protected $logger;

    public function __construct()
    {
        $this->fw = \Base::instance();
        $this->logger = new Log('f3.log');
    }

    protected function isPost(){
        return $this->fw->get('SERVER.REQUEST_METHOD') === 'POST';
    }

    protected function outputJsonResponse(array $array, $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($array);
    }
}