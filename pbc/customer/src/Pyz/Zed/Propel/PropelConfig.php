<?php


namespace Pyz\Zed\Propel;

use Spryker\Zed\Propel\PropelConfig as SprykerPropelConfig;

class PropelConfig extends SprykerPropelConfig
{
    /**
     * @return array
     */
    public function getProjectPropelSchemaPathPatterns()
    {
        //return [APPLICATION_SOURCE_DIR . '/*/Zed/*/Persistence/Propel/Schema/'];

        // PBC don't have project DB changes for now.
        return [];
    }
}
