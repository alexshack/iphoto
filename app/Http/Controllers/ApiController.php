<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ApiController extends Controller
{
    protected $secret = '23fsefdsfsdf';

    public function handleWebhook(Request $request)
    {
        if($request->has('payload')) {
            $json = $request->post('payload');
            $data = json_decode($json, true);

            if ($data['ref'] === 'refs/heads/dev') {
                $scriptPath = base_path('deploy.sh');
                $process = new Process(['sh', $scriptPath], base_path());

                $process->run(null, [
                    'PHP_FPM' => 'php8.1-fpm',
                    'PHP_PATH' => PHP_BINARY,
                    'BRANCH' => 'dev'
                ]);

//                $process = new Process(['git', 'pull', 'origin', 'dev']);
//                $process->run();

                if ($process->isSuccessful()) {
                    return response('Деплой выполнен успешно', 200);
                } else {
                    //return response('Ошибка при выполнении деплоя', 500);
                    return $process->getOutput();
                }
            } else {
                return response('Изменения не по ветке dev, игнорируем запрос', 200);
            }
        } else {
            return response('Некорректный запрос Webhook', 400);
        }

    }

    public function deploy() {
        if($this->checkGitHubHash()) {
//            Log::info('git webhook checked');
//            $process = new Process('sh '.env('DEV_AUTO_DEPLOY_SCRIPT_PATH'));
//            $process->run();
//
//            if (!$process->isSuccessful()) {
//                throw new ProcessFailedException($process);
//            }
//
//            echo $process->getOutput();
            exec('git pull origin dev');
        }

    }

    public function checkGitHubHash() {
        $payload = file_get_contents('php://input');
//        if(!$this->verifyPatreonHash()) {
//            return false;
//        }
        if ($payload['ref'] === 'refs/heads/dev') {
            return false;
        }
        return true;
    }

    function verifyPatreonHash() {
        $patreonBody = request()->getContent();
        $patreonSignature = request()->header('X-Patreon-Signature');
        $webhookHash = hash_hmac('md5', $patreonBody, $this->secret);

        if(strtolower($webhookHash) == strtolower($patreonSignature)) {
            return true; // Verification succeeded
        } else {
            return false; // Verification failed
        }
    }
}
