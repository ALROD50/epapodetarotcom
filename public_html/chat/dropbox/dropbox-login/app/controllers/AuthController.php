<?php
/**
 * IndexController.php
 * @author Lídmo <suporte@lidmo.com.br>
 */

class AuthController extends Controller
{
    protected $dropboxService;

    public function __construct(){
        parent::__construct();
        $this->dropboxService = DropboxService::instance();
    }
    public function index(){
        try{
        view('index.phtml');
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
    public function processAuth()
    {
        $data = [
            'message' => '',
        ];
        try {
            $code = 200;
            $post = $this->fw->get('POST');
            $provider = $this->dropboxService->auth($post['app_id'], $post['app_secret']);
            $data['url'] = $provider->getAuthorizationUrl(['token_access_type' => 'offline']);
            $data['message'] = 'Autenticação bem sucedida!';
        } catch (\Exception $e) {
            $this->logger->write(print_r($e, true));
            $code = 400;
            $data['message'] = $e->getMessage();
        }
        $this->outputJsonResponse($data, $code);
    }

    public function processGenerate()
    {
        $data = [
            'message' => '',
        ];
        try {
            $code = 200;
            $post = $this->fw->get('POST');
            $provider = $this->dropboxService->auth($post['app_id'], $post['app_secret']);
            $accessToken = $provider->getAccessToken('authorization_code', ['code' => $post['code']]);
            $data['json'] = $accessToken->jsonSerialize();
            $data['message'] = 'Json gerado com sucesso!';
        } catch (\Exception $e) {
            $this->logger->write(print_r($e, true));
            $code = 400;
            $data['message'] = $e->getMessage();
            $data['fw'] = $this->fw->get('ENV');
        }
        $this->outputJsonResponse($data, $code);
    }
}