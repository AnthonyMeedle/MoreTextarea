<?php

namespace MoreTextarea\Model\Map;

use MoreTextarea\Model\FolderMoretextarea;
use MoreTextarea\Model\FolderMoretextareaQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'folder_moretextarea' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FolderMoretextareaTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MoreTextarea.Model.Map.FolderMoretextareaTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'folder_moretextarea';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MoreTextarea\\Model\\FolderMoretextarea';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MoreTextarea.Model.FolderMoretextarea';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the ID field
     */
    const ID = 'folder_moretextarea.ID';

    /**
     * the column name for the FOLDER_ID field
     */
    const FOLDER_ID = 'folder_moretextarea.FOLDER_ID';

    /**
     * the column name for the MORETEXTAREA_ID field
     */
    const MORETEXTAREA_ID = 'folder_moretextarea.MORETEXTAREA_ID';

    /**
     * the column name for the LOCALE field
     */
    const LOCALE = 'folder_moretextarea.LOCALE';

    /**
     * the column name for the CHAPO field
     */
    const CHAPO = 'folder_moretextarea.CHAPO';

    /**
     * the column name for the VALUE field
     */
    const VALUE = 'folder_moretextarea.VALUE';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'folder_moretextarea.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'folder_moretextarea.UPDATED_AT';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'FolderId', 'MoretextareaId', 'Locale', 'Chapo', 'Value', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'folderId', 'moretextareaId', 'locale', 'chapo', 'value', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(FolderMoretextareaTableMap::ID, FolderMoretextareaTableMap::FOLDER_ID, FolderMoretextareaTableMap::MORETEXTAREA_ID, FolderMoretextareaTableMap::LOCALE, FolderMoretextareaTableMap::CHAPO, FolderMoretextareaTableMap::VALUE, FolderMoretextareaTableMap::CREATED_AT, FolderMoretextareaTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'FOLDER_ID', 'MORETEXTAREA_ID', 'LOCALE', 'CHAPO', 'VALUE', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'folder_id', 'moretextarea_id', 'locale', 'chapo', 'value', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FolderId' => 1, 'MoretextareaId' => 2, 'Locale' => 3, 'Chapo' => 4, 'Value' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'folderId' => 1, 'moretextareaId' => 2, 'locale' => 3, 'chapo' => 4, 'value' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(FolderMoretextareaTableMap::ID => 0, FolderMoretextareaTableMap::FOLDER_ID => 1, FolderMoretextareaTableMap::MORETEXTAREA_ID => 2, FolderMoretextareaTableMap::LOCALE => 3, FolderMoretextareaTableMap::CHAPO => 4, FolderMoretextareaTableMap::VALUE => 5, FolderMoretextareaTableMap::CREATED_AT => 6, FolderMoretextareaTableMap::UPDATED_AT => 7, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'FOLDER_ID' => 1, 'MORETEXTAREA_ID' => 2, 'LOCALE' => 3, 'CHAPO' => 4, 'VALUE' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'folder_id' => 1, 'moretextarea_id' => 2, 'locale' => 3, 'chapo' => 4, 'value' => 5, 'created_at' => 6, 'updated_at' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('folder_moretextarea');
        $this->setPhpName('FolderMoretextarea');
        $this->setClassName('\\MoreTextarea\\Model\\FolderMoretextarea');
        $this->setPackage('MoreTextarea.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('FOLDER_ID', 'FolderId', 'INTEGER', 'folder', 'ID', true, null, null);
        $this->addForeignKey('MORETEXTAREA_ID', 'MoretextareaId', 'INTEGER', 'moretextarea', 'ID', true, null, null);
        $this->addColumn('LOCALE', 'Locale', 'VARCHAR', false, 5, 'fr_FR');
        $this->addColumn('CHAPO', 'Chapo', 'VARCHAR', false, 255, null);
        $this->addColumn('VALUE', 'Value', 'CLOB', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Moretextarea', '\\MoreTextarea\\Model\\Moretextarea', RelationMap::MANY_TO_ONE, array('moretextarea_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Folder', '\\Thelia\\Model\\Folder', RelationMap::MANY_TO_ONE, array('folder_id' => 'id', ), 'CASCADE', 'RESTRICT');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? FolderMoretextareaTableMap::CLASS_DEFAULT : FolderMoretextareaTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (FolderMoretextarea object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FolderMoretextareaTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FolderMoretextareaTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FolderMoretextareaTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FolderMoretextareaTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FolderMoretextareaTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = FolderMoretextareaTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FolderMoretextareaTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FolderMoretextareaTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(FolderMoretextareaTableMap::ID);
            $criteria->addSelectColumn(FolderMoretextareaTableMap::FOLDER_ID);
            $criteria->addSelectColumn(FolderMoretextareaTableMap::MORETEXTAREA_ID);
            $criteria->addSelectColumn(FolderMoretextareaTableMap::LOCALE);
            $criteria->addSelectColumn(FolderMoretextareaTableMap::CHAPO);
            $criteria->addSelectColumn(FolderMoretextareaTableMap::VALUE);
            $criteria->addSelectColumn(FolderMoretextareaTableMap::CREATED_AT);
            $criteria->addSelectColumn(FolderMoretextareaTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.FOLDER_ID');
            $criteria->addSelectColumn($alias . '.MORETEXTAREA_ID');
            $criteria->addSelectColumn($alias . '.LOCALE');
            $criteria->addSelectColumn($alias . '.CHAPO');
            $criteria->addSelectColumn($alias . '.VALUE');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(FolderMoretextareaTableMap::DATABASE_NAME)->getTable(FolderMoretextareaTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(FolderMoretextareaTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(FolderMoretextareaTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new FolderMoretextareaTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a FolderMoretextarea or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or FolderMoretextarea object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FolderMoretextareaTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MoreTextarea\Model\FolderMoretextarea) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FolderMoretextareaTableMap::DATABASE_NAME);
            $criteria->add(FolderMoretextareaTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = FolderMoretextareaQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { FolderMoretextareaTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { FolderMoretextareaTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the folder_moretextarea table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FolderMoretextareaQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FolderMoretextarea or Criteria object.
     *
     * @param mixed               $criteria Criteria or FolderMoretextarea object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FolderMoretextareaTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FolderMoretextarea object
        }

        if ($criteria->containsKey(FolderMoretextareaTableMap::ID) && $criteria->keyContainsValue(FolderMoretextareaTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FolderMoretextareaTableMap::ID.')');
        }


        // Set the correct dbName
        $query = FolderMoretextareaQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // FolderMoretextareaTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FolderMoretextareaTableMap::buildTableMap();
