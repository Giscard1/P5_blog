<?php

namespace App\Application\Database;

use http\Params;

class PDODatabase extends \PDO
{
    const TYPE_FIELD_SUPPORT = [

        'integer' => parent::PARAM_INT,
        'boolean' => parent::PARAM_BOOL
    ];

    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        parent::__construct($dsn, $username, $passwd, $options);
        parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE,parent::FETCH_ASSOC);
        parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);
    }

    public function request($query, array $params = [])
    {
        $statement = $this->prepare($query);

        foreach ($params as $name => $param) {
            $paramType = gettype($param);
            $bindType = parent::PARAM_STR;

            if ($param instanceof \DateTime) {
                $param = $param->format('Y-m-d H:i:s');
            } else if (array_key_exists($paramType, self::TYPE_FIELD_SUPPORT)) {

                $bindType = self::TYPE_FIELD_SUPPORT[$paramType];
            } else if (is_null($param)) {
                $bindType = parent::PARAM_NULL;
            }

            $statement->bindValue($name, $param, $bindType);
        }

        $statement->execute();

        return $statement;
    }
}
