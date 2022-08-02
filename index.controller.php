<?php

class IndexController {

    private array $data;
    private array $session;
    private ?string $message;

    public function __construct($data,$session)
    {
        $this->data = $data;
        $this->session = $session;
    }

    public function gameStartListener(): void
    {
        if (isset($this->data['startGame']) && $this->data['startGame'] == '1') {
            $this->session['gameHasStarted'] = true;
            $this->session['player'] = 'X';
            $this->session['positions'] = [];
            foreach (Tris::POSITIONS as $key => $vals) {
                foreach ($vals as $val) {
                    $this->session['positions'][$key][$val] = null;
                }
            }
            $this->syncSession();
        }
    }

    public function playerMoveListener(): void
    {
        if (!empty($this->data['position']) && empty($this->session['positions'][$this->data['position']])) {
            $this->session['positions'][$this->data['position'][0]][$this->data['position'][1]] = $this->data['player'];
            $this->session['player'] = $this->session['player'] == 'X' ? 'O' : 'X';
            $this->syncSession();
        } else {
            $this->message = empty($this->data) ? null : 'Move, not valid';
        }
    }

    public function endGameListener(): void
    {
        if (isset($this->data['reset']) && $this->data['reset'] == '1') {
            session_destroy();
            header('Location: ' .$_ENV['APP_URL'] );
            exit;
        }
    }

    public function getSession(): array
    {
        return $this->session;
    }

    public function getMessage(): ?string
    {
        return $this->message ?? null;
    }

    private function syncSession(): void
    {
        $_SESSION = $this->session;
    }
}

$controller = new IndexController($_POST, $_SESSION);
$controller->gameStartListener();
$controller->playerMoveListener();
$controller->endGameListener();

$message = $controller->getMessage();
$session = $controller->getSession();
