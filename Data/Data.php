<?php
namespace SwitchCat\Data;

include_once 'classes/Connections/SqlDAO.php';

use \PDO;
use Exception;

class Data
{
    /**
     * @var \PDO $DAO
     */
    public PDO $DAO;

    /**
     * Data constructor.
     * @param string $dbname
     * @throws \SwitchCat\Connections\ConnectionsException
     */
    public function __construct(string $dbname = '')
    {
        $this->DAO = \SwitchCat\Connections\SqlDAO::getConnection($dbname);
    }

    /**
     * @param string $table
     * @return bool
     * @throws DataException
     */
    public function tableExists(string $table):bool
    {
        $file = 'classes/Data/tableExists.sql';
        if(!file_exists($file))
        {
            throw new \SwitchCat\Data\DataException(__CLASS__ . '::' . __FUNCTION__ . '() - File [' . $file . '] does not seem to exist');
        }
        $sql = file_get_contents($file);
        $stmt = $this->DAO->prepare($sql);
        //echo 'table: ' . $table . PHP_EOL; exit();
        $stmt->bindParam(':table', $table);
        $dbname = 'nebular';
        $stmt->bindParam(':dbname', $dbname);
        if(!$stmt->execute())
        {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @param string $file
     * @param array $params
     * @throws \SwitchCat\Data\DataException
     * @return array
     */
    public function readArrays(string $file, array $params):array
    {
        if(!file_exists($file))
        {
            throw new \SwitchCat\Data\DataException(__CLASS__ . '::' . __FUNCTION__ . '() - File [' . $file . '] does not seem to exist');
        }
        $sql = file_get_contents($file);
        $stmt = $this->DAO->prepare($sql);
        if(count($params) > 0)
        {
            foreach ($params as $param)
            {
                $stmt->bindParam($param['id'], $param['value'], $param['datatype']);
            }
        }
        if($stmt->execute() !== TRUE)
        {
            throw new \SwitchCat\Data\DataException(__CLASS__ . '::' . __FUNCTION__ . '() - Query [ ' . $stmt->debugDumpParams() . ' ] failed');
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}