<?php
/**
 * This file is part of the teamneusta/php-cli-magedev package.
 *
 * Copyright (c) 2017 neusta GmbH | Ein team neusta Unternehmen
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @license https://opensource.org/licenses/mit-license MIT License
 */

namespace TeamNeusta\Magedev\Docker\Container\Repository;

use TeamNeusta\Magedev\Docker\Container\AbstractContainer;

/**
 * Class: FFAIP.
 *
 * @see AbstractContainer
 */
class FFAIP extends AbstractContainer
{
    /**
     * getName.
     */
    public function getName()
    {
        return 'ffaip';
    }

    /**
     * getImage.
     */
    public function getImage()
    {
        return $this->imageFactory->create('FFAIP');
    }

    /**
     * getConfig.
     */
    public function getConfig()
    {
        $homePath = $this->config->get('home_path');
        $projectPath = $this->config->get('project_path');
        $ffaipPath = $this->expandPath($this->config->get('ffaip_path'));

        $binds = [
            $ffaipPath.':/var/www/html:rw',
            $homePath.'/.composer:/var/www/.composer:rw', // TODO: check for existence?
            $homePath.'/.ssh:/var/www/.ssh:rw',
        ];

        $this->setBinds($binds);

        $config = parent::getConfig();

        return $config;
    }

    /**
     * expandPath.
     *
     * file_exist cannot handle short paths like ~ for home folders
     *
     * @param string $path
     *
     * @return string
     */
    public function expandPath($path)
    {
        return str_replace('~', getenv('HOME'), $path);
    }
}
