<?php

namespace pxgamer\GithubDeployKey;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AddCommand extends Command
{
    private $providedRepositories;
    private $validRepositories;
    private $invalidRepositories;
    private $token;
    /**
     * @var Client
     */
    private $client;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Add a new deploy key.')
            ->addArgument('repositories', InputArgument::REQUIRED | InputArgument::IS_ARRAY)
            ->addOption('token', 't', InputOption::VALUE_OPTIONAL, 'A Github personal access token (PAT).');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->providedRepositories = $input->getArgument('repositories');
        $this->token = $input->getOption('token');

        $this->validateToken();
        $this->validateRepos();

        $this->createClient();

        $output->writeln([
            '<comment>Deploy keys added successfully to the following repositories:</comment>',
            '<comment>-------------------------------------------------------------</comment>',
            ''
        ]);

        foreach ($this->validRepositories as $repository) {
            $keyPair = $this->generateKeyPair($repository);

            if ($this->addKey($repository, $keyPair)) {
                $output->writeln([
                    $keyPair['private'],
                    'Private key for: ' . $repository,
                    'Public key added to: https://github.com/' . $repository . '/settings/keys',
                ]);
            }
        }
    }

    private function generateKeyPair($repo)
    {
        $type = 'rsa';
        $bits = '4096';
        $pass_phrase = '';
        $comment = 'Deploy key for ' . $repo;
        $dir = getcwd() . '/' . $repo . '/' . time();
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = $dir . '/' . 'id_' . $type;

        $command = 'ssh-keygen -t ' . $type . ' -b ' . $bits . ' -f ' . $filename . ' -N "' . $pass_phrase . '" -C "' . $comment . '" -q';

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return [
            'type' => $type,
            'bits' => $bits,
            'comment' => $comment,
            'public' => file_get_contents($filename . '.pub'),
            'private' => file_get_contents($filename),
        ];
    }

    private function addKey($repository, $keyPair)
    {
        $response = $this->client->post(
            '/repos/' . $repository . '/keys',
            [
                'json' => [
                    'title' => $keyPair['comment'],
                    'key' => $keyPair['public'],
                    'read_only' => true
                ]
            ]
        );

        if ($response->getStatusCode() === 201) {
            return true;
        }

        return false;
    }

    private function createClient()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.github.com',
            'headers' => [
                'User-Agent' => 'github-deploy-key-php',
                'Accept' => 'application/vnd.github.v3+json',
                'Authorization' => 'token ' . $this->token
            ]
        ]);
    }

    private function validateToken()
    {
        if (!$this->token) {
            $this->error('Please provide a Github token [--token rando]');
        }

        if (strlen($this->token) < 40) {
            $this->error('Please provide a valid Github token.');
        }

        return false;
    }

    private function validateRepos()
    {
        if (!$this->providedRepositories) {
            $this->error('Please provide some Github repositories');
        }

        foreach ($this->providedRepositories as $repository) {
            $repository = strtolower($repository);
            if (preg_match('/([\S]+)\/([\S]+)/', $repository)) {
                $this->validRepositories[] = $repository;
            } else {
                $this->invalidRepositories[] = $repository;
            }
        }

        if (!empty($this->validRepositories)) {
            return true;
        } else {
            $this->error('Please provide a valid Github repository');
        }

        return false;
    }

    private function error($message)
    {
        throw new \ErrorException($message);
    }
}