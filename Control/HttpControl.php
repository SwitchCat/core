<?php declare(strict_types=1);
/**
 * File:    HttpControl.php
 * Created: 18-11-20
 */

namespace SwitchCat\Control;

use Gregwar\Cache\Cache;
use SwitchCat\Exception\SwitchCatException;
use SwitchCat\Templates\Builder;
use SwitchCat\Templates\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\AcceptHeader;

/**
 * Class HttpControl
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 *
 * @package   SwitchCat\Control
 */
class HttpControl extends Control
{
    /**
     * @var Request $Request
     */
    private Request $Request;

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

        $this->data['defaults'] = Manager::getDefaults();
        if(!is_array($this->data) || empty($this->data))
        {
            throw new SwitchCatException([__CLASS__, __FUNCTION__],'Unable to fetch data for requested document: ' . $this->requested);
        }

        $this->Request = Request::createFromGlobals();
    }

    public function process(): void
    {
        // add document data handling and generation here in child controllers
    }

    /**
     * Access request vars with Request object
     * @link https://symfony.com/doc/current/components/http_foundation.html
     */
    public function validate():void
    {
        $acceptHeader = AcceptHeader::fromString($this->Request->headers->get('Accept'));
        if(!$acceptHeader->has('text/html'))
        {
            throw new SwitchCatException([__CLASS__, __FUNCTION__], 'Invalid document header');
        }
    }

    /**
     * Cache managed by gregwar/cache package
     * @link https://packagist.org/packages/gregwar/cache
     */
    public function response(): void
    {
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            $this->requested . '.html',
            ['max-age' => ($this->IniParams->mode === 'prod') ? $this->IniParams->maxage : 0],
            function()
            {
                Builder::start($this->data, Manager::getLayout($this->requested));
            }
        );

        // Build the response object
        $Response = new Response(
            $document,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        $Response->setCache([
            'must_revalidate'  => false,
            'no_cache'         => false,
            'no_store'         => false,
            'no_transform'     => false,
            'public'           => true,
            'private'          => false,
            'proxy_revalidate' => false,
            'max_age'          => 600,
            's_maxage'         => 600,
            'immutable'        => true,
            'last_modified'    => new \DateTime(),
            'etag'             => 'abcdef'
        ]);

        // Send response
        $Response->prepare($this->Request);
        $Response->send();

        die();
    }
}