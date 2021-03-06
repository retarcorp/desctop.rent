<?php

namespace Classes\Utils;

class System {
    
    private $lastStatus = '';
    private $lastCommand = '';
    private $lastOutput = '';
    
    public function execute(string $command){
        $this->lastCommand = $command;
        exec($command, $this->lastOutput, $this->lastStatus);
    }
    
    public function getResult(string $command): array{
        $this->execute($command);
        return $this->lastOutput;
    }
    
    public function getLastCommand(): string{
        return $this->lastCommand;
    }
    
    public function getLastStatus(): string{
        return $this->lastStatus;
    }
    
    public function getLastResult(): array{
        return $this->lastOutput;
    }
    
}