<?php


namespace App\Process;


use CzProject\GitPhp\CommandProcessor;
use CzProject\GitPhp\GitException;
use CzProject\GitPhp\RunnerResult;
use Throwable;

class Runner
{
    private CommandProcessor $commandProcessor;
    private string $cwd;
    
    public function __construct(string $cwd)
    {
        $this->commandProcessor = new CommandProcessor();
        $this->cwd = $cwd;
    }
    
    public function run(string $binary, array $args = [], array $env = null)
    {
        $result = $this->execute($binary, $this->cwd, $args, $env);
    
        if (!$result->isOk()) {
            throw new GitException("Command '{$result->getCommand()}' failed (exit-code {$result->getExitCode()}).", $result->getExitCode(), NULL, $result);
        }
    
        return $result;
    }
    
    private function execute(string $binary, string $cwd, array $args = [], array $env = null) : RunnerResult
    {
        if (!is_dir($cwd)) {
            throw new GitException("Directory '$cwd' not found");
        }
    
        $descriptor = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];
    
        $pipes = [];
        $command = $this->commandProcessor->process($binary, $args);
        $process = proc_open($command, $descriptor, $pipes, $cwd, $env, [
            'bypass_shell' => TRUE,
        ]);
    
        if (!$process) {
            throw new GitException("Executing of command '$command' failed (directory $cwd).");
        }
    
        // Reset output and error
        stream_set_blocking($pipes[1], FALSE);
        stream_set_blocking($pipes[2], FALSE);
        $stdout = '';
        $stderr = '';
    
        while (true) {
            try {
                $stdoutOutput = stream_get_contents($pipes[1]) ?? false;
            } catch (Throwable $exception) {
                $stdoutOutput = false;
            }
        
            if (is_string($stdoutOutput)) {
                $stdout .= $stdoutOutput;
            }
        
            try {
                $stderrOutput = stream_get_contents($pipes[2]) ?? false;
            } catch (Throwable $exception) {
                $stderrOutput = false;
            }
    
            try {
                if (is_string($stderrOutput)) {
                    $stderr .= $stderrOutput;
                }
            } catch (Throwable $exception) {
                 $stderr .= ' ';
            }
           
            
            try {
                if ((feof($pipes[1]) || $stdoutOutput === FALSE) && (feof($pipes[2]) || $stderrOutput === FALSE)) {
                    break;
                }
            } catch (Throwable $exception) {
                break;
            }
           
        }
    
        $returnCode = proc_close($process);
        return new RunnerResult($command, $returnCode, $this->convertOutput($stdout), $this->convertOutput($stderr));
    }
    
    private function convertOutput($output): array
    {
        $output = str_replace(["\r\n", "\r"], "\n", $output);
        $output = rtrim($output, "\n");
        
        if ($output === '') {
            return [];
        }
        
        return explode("\n", $output);
    }
    
}
