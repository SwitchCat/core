<?php

namespace SwitchCat\Control;


final class SwitchCatInitAppControl extends SwitchCatControl
{
    /**
     * @var array $data
     */
    private array  $data;

    public function run(array $options = []): void
    {
        $params = [];

        \SwitchCat\Cli\Cli::Climate()->green()->out("Starting app initialisation...");
        \SwitchCat\Cli\Cli::Climate()->br();
        // Application name
        $params['app_name'] = \SwitchCat\Cli\Cli::Climate()->input('Application name: [ press enter to keep "' . basename(getcwd()) . '" ]')->defaultTo(basename(getcwd()))->prompt();
        \SwitchCat\Cli\Cli::Climate()->yellow('Application name is: ' . $params['app_name']);
        \SwitchCat\Cli\Cli::Climate()->br();
        // Application description
        $input = \SwitchCat\Cli\Cli::Climate()->input('Description: [ press ctrl+D to end ]');
        \SwitchCat\Cli\Cli::Climate()->br();
        $input->multiLine();
        $params['app_description'] = $input->prompt();
        \SwitchCat\Cli\Cli::Climate()->br();
        // License
        $options  =
            [
                'None',
                'Apache License 2.0 ',
                'GNU General Public License v3.0 ',
                'MIT License ',
                'BSD 2-Clause "Simplified" License',
                'BSD 3-Clause "New" or "Revised" License',
                'Boost Software License 1.0 ',
                'Creative Commons Zero v1.0 Universal',
                'Eclipse Public License 2.0',
                'GNU Affero General Public License v3.0',
                'GNU General Public License v2.0',
                'GNU Lesser General Public License v2.1',
                'Mozilla Public License 2.0',
                'The Unlicense'
            ];
        $input    = \SwitchCat\Cli\Cli::Climate()->radio('Select license: ', $options);
        $params['license'] = $input->prompt();
        \SwitchCat\Cli\Cli::Climate()->br();
        // Author
        $params['author'] = \SwitchCat\Cli\Cli::Climate()->input('Application author: ')->prompt();
        $params['company'] = \SwitchCat\Cli\Cli::Climate()->input('Company: ')->prompt();
        $info = TRUE;
        if($params['company'] === '')
        {
            $info = FALSE;
        }
        $params['email'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Email: ')->prompt() : '';
        $params['phone'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Phone: ')->prompt() : '';
        $params['country'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Country: ')->prompt() : '';
        $params['city'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('City: ')->prompt() : '';
        $params['zip'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Zipcode: ')->prompt() : '';
        $params['street'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Street: ')->prompt() : '';
        $params['housenumber'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Housenumber: ')->prompt() : '';
        $params['letterbox'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Letterbox: ')->prompt() : '';
        $params['website'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Website: ')->prompt() : '';
        \SwitchCat\Cli\Cli::Climate()->br();
        // Application default language
        $params['app_default_language'] = \SwitchCat\Cli\Cli::Climate()->input('Application default language [en]')->defaultTo('en')->prompt();
        // Application local root
        $params['app_root_local'] = \SwitchCat\Cli\Cli::Climate()->input('Application local root [ press enter to keep: http://localhost/' . basename(getcwd()) . ' ]: ')->defaultTo('http://localhost/' . basename(getcwd()) . '/')->prompt();
        \SwitchCat\Cli\Cli::Climate()->yellow('Application local root is: ' . $params['app_root_local']);
        \SwitchCat\Cli\Cli::Climate()->br();
        // Application online root
        $params['app_root_online'] = \SwitchCat\Cli\Cli::Climate()->input('Application domain (https://mydomain.com): ')->prompt();
        if($params['app_root_online'] === '')
        {
            \SwitchCat\Cli\Cli::Climate()->yellow('No domain for this application');
        }
        else
        {
            \SwitchCat\Cli\Cli::Climate()->yellow('Application domain is: ' . $params['app_root_online']);
        }
        \SwitchCat\Cli\Cli::Climate()->br();
        // Application database
        $params['app_database'] = \SwitchCat\Cli\Cli::Climate()->input('Application database name (leave blank if none): ')->prompt();
        \SwitchCat\Cli\Cli::Climate()->yellow('Database name is: ' . $params['app_database']);
        \SwitchCat\Cli\Cli::Climate()->br();
        $info = TRUE;
        if($params['app_database'] === '')
        {
            $info = FALSE;
        }
        // Database username
        $params['app_database_user'] = $info ? \SwitchCat\Cli\Cli::Climate()->input('Database user name: ')->prompt() : '';
        // Database password
        $params['app_database_pwd'] = $info ? \SwitchCat\Cli\Cli::Climate()->password('Database user password: ')->prompt() : '';

        $this->Climate->br();
        if(\SwitchCat\Initializer\Initializer::createIniFile($params))
        {
            \SwitchCat\Cli\Cli::Climate()->green()->out('Ini file created.');
            \SwitchCat\Cli\Cli::Climate()->green()->out('You can find the file at ini/app.ini.');
            \SwitchCat\Cli\Cli::Climate()->green()->out('It contains a template off all vars used in your app. Edit it to customize your app to your needs');
            \SwitchCat\Cli\Cli::Climate()->br();
            \SwitchCat\Cli\Cli::Climate()->green()->out('Have fun!!!');
            die();
        }
        else
        {
            \SwitchCat\Cli\Cli::Climate()->red()->out('Ini file could not be created.');
            die();
        }
        \SwitchCat\Cli\Cli::Climate()->br();
    }
}