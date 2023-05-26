<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ApiController extends Controller
{
    protected $secret = '23fsefdsfsdf';

    public function deploy() {
        if($this->checkGitHubHash() && $this->checkGitHubPushEvent()) {
            $process = new Process('sh '.env('DEV_AUTO_DEPLOY_SCRIPT_PATH'));
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            echo $process->getOutput();
        }

    }

    public function checkGitHubHash() {
        $payload = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
        list($algorithm, $hash) = explode('=', $signature, 2);
        $expectedHash = hash_hmac($algorithm, $payload, $this->secret);

        if ($hash !== $expectedHash) {
            return false;
        }
        if ($payload['ref'] === 'refs/heads/dev') {
            return false;
        }
        return true;
    }

    public function checkGitHubPushEvent() {
        $event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';
        if ($event !== 'push') {
            return false;
        }
        return true;
    }
}
