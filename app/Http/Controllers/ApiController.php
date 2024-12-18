<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ApiController extends Controller
{

    public function handleWebhook(Request $request)
    {
        if($request->has('payload')) {
            $json = $request->post('payload');
            $data = json_decode($json, true);
            if(!$this->check($request)) {
                return response('Ошибка авторизации', 403);
            }
            $branch = '';
            if(Config::get('app.env') == 'production') {
                $branch = 'refs/heads/master';
            } else {
                $branch = 'refs/heads/dev';
            }
            if ($data['ref'] === $branch) {
                $scriptPath = base_path('deploy.sh');
                $process = new Process(['/bin/bash', $scriptPath]);
                $process->setWorkingDirectory(base_path());
                $process->run(function($type, $buffer) {
                    Log::info($buffer);
                });

                if ($process->isSuccessful()) {
                    return response('Деплой выполнен успешно', 200);
                } else {
                    return response('Ошибка при выполнении деплоя', 500);
                }
            } else {
                return response('Изменения не по ветке dev, игнорируем запрос', 200);
            }
        } else {
            return response('Некорректный запрос Webhook', 400);
        }

    }

    public function check(Request $request)
    {

        $githubtoken = $request->header('X-Hub-Signature');
        $myTokenHash = 'sha1=' . hash_hmac('sha1',$request->getContent(), Config::get('app.github_secret'));
        if($githubtoken != $myTokenHash) {
            Log::info(Config::get('app.github_secret'));
            Log::info($githubtoken);
            Log::info($myTokenHash);
            return false;
        }
        return true;
    }
}
