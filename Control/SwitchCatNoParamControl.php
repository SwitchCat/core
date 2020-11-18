<?php


namespace SwitchCat\Control;


final class SwitchCatNoParamControl extends SwitchCatControl
{
    public function run(array $options = []): void
    {
        $data =
            [
                'response' => $this->showTitle() . $this->showOptions()
            ];
        $this->response('cli', 0, $data);
        exit();
    }
}