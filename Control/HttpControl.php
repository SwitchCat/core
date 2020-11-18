<?php
/**
 * File:    HttpControl.php
 * Created: 18-11-20
 */

namespace SwitchCat\Control;


class HttpControl extends Control
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request $Request
     */
    private \Symfony\Component\HttpFoundation\Request $Request;

    /**
     * @var \League\Plates\Engine $Plates
     */
    private \League\Plates\Engine $Plates;

    /**
     * @var array $templates
     */
    private array $templates;

    /**
     * @var string $requested
     */
    protected string $requested;

    /**
     * @var array $data
     */
    protected array $data;

    /**
     * HttpControl constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->Request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        $this->Plates = new \League\Plates\Engine('templates');
        $this->templates = \SwitchCat\Initializer\Initializer::getTemplates();
    }

    public function process(): void
    {
        $this->data = \SwitchCat\Initializer\Initializer::getTemplateDefaults(\SwitchCat\Initializer\Initializer::getTemplates()['active'])[$this->requested];
        if(!is_array($this->data) || empty($this->data))
        {
            throw new \SwitchCat\Control\ControlException($message = "Unable to fetch data for template " . \SwitchCat\Initializer\Initializer::getTemplates()['active'] . " - document requested: " . $this->requested, __CLASS__, __FUNCTION__);
        }
    }

    /**
     * Access request vars with Request object
     * @link https://symfony.com/doc/current/components/http_foundation.html
     * @return bool
     */
    public function validate():void
    {

    }

    public function response(): void
    {
        if(\SwitchCat\Initializer\Initializer::$ini['app']['mode'] === 'PROD')
        {
            $Cache = new \SwitchCat\Cache\FileCache('cache/');
            if(!$document = $Cache->get($this->templates['active'] . '\\' . $this->requested))
            {
                $document = $this->build();
                $Cache->set($this->templates['active'] . '\\' . $this->requested, $document, 0, FALSE);
            }
        }
        else
        {
            $document = $this->build();
        }

        // Build the response object
        $Response = new \Symfony\Component\HttpFoundation\Response(
            $document,
            \Symfony\Component\HttpFoundation\Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        // Send response
        $Response->send();

        die();
    }

    /**
     * @return string
     */
    private function build():string
    {
        $defaults = \SwitchCat\Initializer\Initializer::getTemplateDefaults($this->templates[$this->templates['active']]['templates']['main']);
        foreach ($this->templates[$this->templates['active']]['templates'] as $tpl_name => $tpl_folder)
        {
            $this->Plates->addData(isset($this->data[$tpl_name]) ? $this->data[$tpl_name] : $defaults[$tpl_name], $tpl_folder . $tpl_name);
        }
        return $this->Plates->render($this->templates[$this->templates['active']]['templates']['main'] . 'main' );
    }
}