<?php

namespace MoreTextarea\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use MoreTextarea\Model\CategoryMoretextarea as ChildCategoryMoretextarea;
use MoreTextarea\Model\CategoryMoretextareaQuery as ChildCategoryMoretextareaQuery;
use MoreTextarea\Model\ContentMoretextarea as ChildContentMoretextarea;
use MoreTextarea\Model\ContentMoretextareaQuery as ChildContentMoretextareaQuery;
use MoreTextarea\Model\FolderMoretextarea as ChildFolderMoretextarea;
use MoreTextarea\Model\FolderMoretextareaQuery as ChildFolderMoretextareaQuery;
use MoreTextarea\Model\Moretextarea as ChildMoretextarea;
use MoreTextarea\Model\MoretextareaQuery as ChildMoretextareaQuery;
use MoreTextarea\Model\ProductMoretextarea as ChildProductMoretextarea;
use MoreTextarea\Model\ProductMoretextareaQuery as ChildProductMoretextareaQuery;
use MoreTextarea\Model\Map\MoretextareaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class Moretextarea implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MoreTextarea\\Model\\Map\\MoretextareaTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the typobj field.
     * @var        int
     */
    protected $typobj;

    /**
     * The value for the typch field.
     * @var        int
     */
    protected $typch;

    /**
     * The value for the template_id field.
     * @var        int
     */
    protected $template_id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildProductMoretextarea[] Collection to store aggregation of ChildProductMoretextarea objects.
     */
    protected $collProductMoretextareas;
    protected $collProductMoretextareasPartial;

    /**
     * @var        ObjectCollection|ChildCategoryMoretextarea[] Collection to store aggregation of ChildCategoryMoretextarea objects.
     */
    protected $collCategoryMoretextareas;
    protected $collCategoryMoretextareasPartial;

    /**
     * @var        ObjectCollection|ChildFolderMoretextarea[] Collection to store aggregation of ChildFolderMoretextarea objects.
     */
    protected $collFolderMoretextareas;
    protected $collFolderMoretextareasPartial;

    /**
     * @var        ObjectCollection|ChildContentMoretextarea[] Collection to store aggregation of ChildContentMoretextarea objects.
     */
    protected $collContentMoretextareas;
    protected $collContentMoretextareasPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $productMoretextareasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $categoryMoretextareasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $folderMoretextareasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $contentMoretextareasScheduledForDeletion = null;

    /**
     * Initializes internal state of MoreTextarea\Model\Base\Moretextarea object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Moretextarea</code> instance.  If
     * <code>obj</code> is an instance of <code>Moretextarea</code>, delegates to
     * <code>equals(Moretextarea)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return Moretextarea The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return Moretextarea The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [position] column value.
     *
     * @return   int
     */
    public function getPosition()
    {

        return $this->position;
    }

    /**
     * Get the [typobj] column value.
     *
     * @return   int
     */
    public function getTypobj()
    {

        return $this->typobj;
    }

    /**
     * Get the [typch] column value.
     *
     * @return   int
     */
    public function getTypch()
    {

        return $this->typch;
    }

    /**
     * Get the [template_id] column value.
     *
     * @return   int
     */
    public function getTemplateId()
    {

        return $this->template_id;
    }

    /**
     * Get the [title] column value.
     *
     * @return   string
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MoretextareaTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [position] column.
     *
     * @param      int $v new value
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[MoretextareaTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [typobj] column.
     *
     * @param      int $v new value
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setTypobj($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->typobj !== $v) {
            $this->typobj = $v;
            $this->modifiedColumns[MoretextareaTableMap::TYPOBJ] = true;
        }


        return $this;
    } // setTypobj()

    /**
     * Set the value of [typch] column.
     *
     * @param      int $v new value
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setTypch($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->typch !== $v) {
            $this->typch = $v;
            $this->modifiedColumns[MoretextareaTableMap::TYPCH] = true;
        }


        return $this;
    } // setTypch()

    /**
     * Set the value of [template_id] column.
     *
     * @param      int $v new value
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setTemplateId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->template_id !== $v) {
            $this->template_id = $v;
            $this->modifiedColumns[MoretextareaTableMap::TEMPLATE_ID] = true;
        }


        return $this;
    } // setTemplateId()

    /**
     * Set the value of [title] column.
     *
     * @param      string $v new value
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[MoretextareaTableMap::TITLE] = true;
        }


        return $this;
    } // setTitle()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[MoretextareaTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[MoretextareaTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MoretextareaTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MoretextareaTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MoretextareaTableMap::translateFieldName('Typobj', TableMap::TYPE_PHPNAME, $indexType)];
            $this->typobj = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MoretextareaTableMap::translateFieldName('Typch', TableMap::TYPE_PHPNAME, $indexType)];
            $this->typch = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MoretextareaTableMap::translateFieldName('TemplateId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->template_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : MoretextareaTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : MoretextareaTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : MoretextareaTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = MoretextareaTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \MoreTextarea\Model\Moretextarea object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MoretextareaTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMoretextareaQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collProductMoretextareas = null;

            $this->collCategoryMoretextareas = null;

            $this->collFolderMoretextareas = null;

            $this->collContentMoretextareas = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Moretextarea::setDeleted()
     * @see Moretextarea::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MoretextareaTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildMoretextareaQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MoretextareaTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(MoretextareaTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(MoretextareaTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(MoretextareaTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                MoretextareaTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->productMoretextareasScheduledForDeletion !== null) {
                if (!$this->productMoretextareasScheduledForDeletion->isEmpty()) {
                    \MoreTextarea\Model\ProductMoretextareaQuery::create()
                        ->filterByPrimaryKeys($this->productMoretextareasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productMoretextareasScheduledForDeletion = null;
                }
            }

                if ($this->collProductMoretextareas !== null) {
            foreach ($this->collProductMoretextareas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->categoryMoretextareasScheduledForDeletion !== null) {
                if (!$this->categoryMoretextareasScheduledForDeletion->isEmpty()) {
                    \MoreTextarea\Model\CategoryMoretextareaQuery::create()
                        ->filterByPrimaryKeys($this->categoryMoretextareasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->categoryMoretextareasScheduledForDeletion = null;
                }
            }

                if ($this->collCategoryMoretextareas !== null) {
            foreach ($this->collCategoryMoretextareas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->folderMoretextareasScheduledForDeletion !== null) {
                if (!$this->folderMoretextareasScheduledForDeletion->isEmpty()) {
                    \MoreTextarea\Model\FolderMoretextareaQuery::create()
                        ->filterByPrimaryKeys($this->folderMoretextareasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->folderMoretextareasScheduledForDeletion = null;
                }
            }

                if ($this->collFolderMoretextareas !== null) {
            foreach ($this->collFolderMoretextareas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentMoretextareasScheduledForDeletion !== null) {
                if (!$this->contentMoretextareasScheduledForDeletion->isEmpty()) {
                    \MoreTextarea\Model\ContentMoretextareaQuery::create()
                        ->filterByPrimaryKeys($this->contentMoretextareasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentMoretextareasScheduledForDeletion = null;
                }
            }

                if ($this->collContentMoretextareas !== null) {
            foreach ($this->collContentMoretextareas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[MoretextareaTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MoretextareaTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MoretextareaTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(MoretextareaTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(MoretextareaTableMap::TYPOBJ)) {
            $modifiedColumns[':p' . $index++]  = 'TYPOBJ';
        }
        if ($this->isColumnModified(MoretextareaTableMap::TYPCH)) {
            $modifiedColumns[':p' . $index++]  = 'TYPCH';
        }
        if ($this->isColumnModified(MoretextareaTableMap::TEMPLATE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPLATE_ID';
        }
        if ($this->isColumnModified(MoretextareaTableMap::TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'TITLE';
        }
        if ($this->isColumnModified(MoretextareaTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(MoretextareaTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO moretextarea (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'POSITION':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'TYPOBJ':
                        $stmt->bindValue($identifier, $this->typobj, PDO::PARAM_INT);
                        break;
                    case 'TYPCH':
                        $stmt->bindValue($identifier, $this->typch, PDO::PARAM_INT);
                        break;
                    case 'TEMPLATE_ID':
                        $stmt->bindValue($identifier, $this->template_id, PDO::PARAM_INT);
                        break;
                    case 'TITLE':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MoretextareaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getPosition();
                break;
            case 2:
                return $this->getTypobj();
                break;
            case 3:
                return $this->getTypch();
                break;
            case 4:
                return $this->getTemplateId();
                break;
            case 5:
                return $this->getTitle();
                break;
            case 6:
                return $this->getCreatedAt();
                break;
            case 7:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Moretextarea'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Moretextarea'][$this->getPrimaryKey()] = true;
        $keys = MoretextareaTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPosition(),
            $keys[2] => $this->getTypobj(),
            $keys[3] => $this->getTypch(),
            $keys[4] => $this->getTemplateId(),
            $keys[5] => $this->getTitle(),
            $keys[6] => $this->getCreatedAt(),
            $keys[7] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collProductMoretextareas) {
                $result['ProductMoretextareas'] = $this->collProductMoretextareas->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCategoryMoretextareas) {
                $result['CategoryMoretextareas'] = $this->collCategoryMoretextareas->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFolderMoretextareas) {
                $result['FolderMoretextareas'] = $this->collFolderMoretextareas->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentMoretextareas) {
                $result['ContentMoretextareas'] = $this->collContentMoretextareas->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MoretextareaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPosition($value);
                break;
            case 2:
                $this->setTypobj($value);
                break;
            case 3:
                $this->setTypch($value);
                break;
            case 4:
                $this->setTemplateId($value);
                break;
            case 5:
                $this->setTitle($value);
                break;
            case 6:
                $this->setCreatedAt($value);
                break;
            case 7:
                $this->setUpdatedAt($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = MoretextareaTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPosition($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTypobj($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTypch($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setTemplateId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setTitle($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MoretextareaTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MoretextareaTableMap::ID)) $criteria->add(MoretextareaTableMap::ID, $this->id);
        if ($this->isColumnModified(MoretextareaTableMap::POSITION)) $criteria->add(MoretextareaTableMap::POSITION, $this->position);
        if ($this->isColumnModified(MoretextareaTableMap::TYPOBJ)) $criteria->add(MoretextareaTableMap::TYPOBJ, $this->typobj);
        if ($this->isColumnModified(MoretextareaTableMap::TYPCH)) $criteria->add(MoretextareaTableMap::TYPCH, $this->typch);
        if ($this->isColumnModified(MoretextareaTableMap::TEMPLATE_ID)) $criteria->add(MoretextareaTableMap::TEMPLATE_ID, $this->template_id);
        if ($this->isColumnModified(MoretextareaTableMap::TITLE)) $criteria->add(MoretextareaTableMap::TITLE, $this->title);
        if ($this->isColumnModified(MoretextareaTableMap::CREATED_AT)) $criteria->add(MoretextareaTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(MoretextareaTableMap::UPDATED_AT)) $criteria->add(MoretextareaTableMap::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(MoretextareaTableMap::DATABASE_NAME);
        $criteria->add(MoretextareaTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MoreTextarea\Model\Moretextarea (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPosition($this->getPosition());
        $copyObj->setTypobj($this->getTypobj());
        $copyObj->setTypch($this->getTypch());
        $copyObj->setTemplateId($this->getTemplateId());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getProductMoretextareas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProductMoretextarea($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCategoryMoretextareas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCategoryMoretextarea($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFolderMoretextareas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFolderMoretextarea($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentMoretextareas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentMoretextarea($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \MoreTextarea\Model\Moretextarea Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ProductMoretextarea' == $relationName) {
            return $this->initProductMoretextareas();
        }
        if ('CategoryMoretextarea' == $relationName) {
            return $this->initCategoryMoretextareas();
        }
        if ('FolderMoretextarea' == $relationName) {
            return $this->initFolderMoretextareas();
        }
        if ('ContentMoretextarea' == $relationName) {
            return $this->initContentMoretextareas();
        }
    }

    /**
     * Clears out the collProductMoretextareas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProductMoretextareas()
     */
    public function clearProductMoretextareas()
    {
        $this->collProductMoretextareas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProductMoretextareas collection loaded partially.
     */
    public function resetPartialProductMoretextareas($v = true)
    {
        $this->collProductMoretextareasPartial = $v;
    }

    /**
     * Initializes the collProductMoretextareas collection.
     *
     * By default this just sets the collProductMoretextareas collection to an empty array (like clearcollProductMoretextareas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProductMoretextareas($overrideExisting = true)
    {
        if (null !== $this->collProductMoretextareas && !$overrideExisting) {
            return;
        }
        $this->collProductMoretextareas = new ObjectCollection();
        $this->collProductMoretextareas->setModel('\MoreTextarea\Model\ProductMoretextarea');
    }

    /**
     * Gets an array of ChildProductMoretextarea objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMoretextarea is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildProductMoretextarea[] List of ChildProductMoretextarea objects
     * @throws PropelException
     */
    public function getProductMoretextareas($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProductMoretextareasPartial && !$this->isNew();
        if (null === $this->collProductMoretextareas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProductMoretextareas) {
                // return empty collection
                $this->initProductMoretextareas();
            } else {
                $collProductMoretextareas = ChildProductMoretextareaQuery::create(null, $criteria)
                    ->filterByMoretextarea($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductMoretextareasPartial && count($collProductMoretextareas)) {
                        $this->initProductMoretextareas(false);

                        foreach ($collProductMoretextareas as $obj) {
                            if (false == $this->collProductMoretextareas->contains($obj)) {
                                $this->collProductMoretextareas->append($obj);
                            }
                        }

                        $this->collProductMoretextareasPartial = true;
                    }

                    reset($collProductMoretextareas);

                    return $collProductMoretextareas;
                }

                if ($partial && $this->collProductMoretextareas) {
                    foreach ($this->collProductMoretextareas as $obj) {
                        if ($obj->isNew()) {
                            $collProductMoretextareas[] = $obj;
                        }
                    }
                }

                $this->collProductMoretextareas = $collProductMoretextareas;
                $this->collProductMoretextareasPartial = false;
            }
        }

        return $this->collProductMoretextareas;
    }

    /**
     * Sets a collection of ProductMoretextarea objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $productMoretextareas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildMoretextarea The current object (for fluent API support)
     */
    public function setProductMoretextareas(Collection $productMoretextareas, ConnectionInterface $con = null)
    {
        $productMoretextareasToDelete = $this->getProductMoretextareas(new Criteria(), $con)->diff($productMoretextareas);


        $this->productMoretextareasScheduledForDeletion = $productMoretextareasToDelete;

        foreach ($productMoretextareasToDelete as $productMoretextareaRemoved) {
            $productMoretextareaRemoved->setMoretextarea(null);
        }

        $this->collProductMoretextareas = null;
        foreach ($productMoretextareas as $productMoretextarea) {
            $this->addProductMoretextarea($productMoretextarea);
        }

        $this->collProductMoretextareas = $productMoretextareas;
        $this->collProductMoretextareasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProductMoretextarea objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ProductMoretextarea objects.
     * @throws PropelException
     */
    public function countProductMoretextareas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProductMoretextareasPartial && !$this->isNew();
        if (null === $this->collProductMoretextareas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProductMoretextareas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProductMoretextareas());
            }

            $query = ChildProductMoretextareaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMoretextarea($this)
                ->count($con);
        }

        return count($this->collProductMoretextareas);
    }

    /**
     * Method called to associate a ChildProductMoretextarea object to this object
     * through the ChildProductMoretextarea foreign key attribute.
     *
     * @param    ChildProductMoretextarea $l ChildProductMoretextarea
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function addProductMoretextarea(ChildProductMoretextarea $l)
    {
        if ($this->collProductMoretextareas === null) {
            $this->initProductMoretextareas();
            $this->collProductMoretextareasPartial = true;
        }

        if (!in_array($l, $this->collProductMoretextareas->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProductMoretextarea($l);
        }

        return $this;
    }

    /**
     * @param ProductMoretextarea $productMoretextarea The productMoretextarea object to add.
     */
    protected function doAddProductMoretextarea($productMoretextarea)
    {
        $this->collProductMoretextareas[]= $productMoretextarea;
        $productMoretextarea->setMoretextarea($this);
    }

    /**
     * @param  ProductMoretextarea $productMoretextarea The productMoretextarea object to remove.
     * @return ChildMoretextarea The current object (for fluent API support)
     */
    public function removeProductMoretextarea($productMoretextarea)
    {
        if ($this->getProductMoretextareas()->contains($productMoretextarea)) {
            $this->collProductMoretextareas->remove($this->collProductMoretextareas->search($productMoretextarea));
            if (null === $this->productMoretextareasScheduledForDeletion) {
                $this->productMoretextareasScheduledForDeletion = clone $this->collProductMoretextareas;
                $this->productMoretextareasScheduledForDeletion->clear();
            }
            $this->productMoretextareasScheduledForDeletion[]= clone $productMoretextarea;
            $productMoretextarea->setMoretextarea(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Moretextarea is new, it will return
     * an empty collection; or if this Moretextarea has previously
     * been saved, it will retrieve related ProductMoretextareas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Moretextarea.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildProductMoretextarea[] List of ChildProductMoretextarea objects
     */
    public function getProductMoretextareasJoinProduct($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProductMoretextareaQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getProductMoretextareas($query, $con);
    }

    /**
     * Clears out the collCategoryMoretextareas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCategoryMoretextareas()
     */
    public function clearCategoryMoretextareas()
    {
        $this->collCategoryMoretextareas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCategoryMoretextareas collection loaded partially.
     */
    public function resetPartialCategoryMoretextareas($v = true)
    {
        $this->collCategoryMoretextareasPartial = $v;
    }

    /**
     * Initializes the collCategoryMoretextareas collection.
     *
     * By default this just sets the collCategoryMoretextareas collection to an empty array (like clearcollCategoryMoretextareas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCategoryMoretextareas($overrideExisting = true)
    {
        if (null !== $this->collCategoryMoretextareas && !$overrideExisting) {
            return;
        }
        $this->collCategoryMoretextareas = new ObjectCollection();
        $this->collCategoryMoretextareas->setModel('\MoreTextarea\Model\CategoryMoretextarea');
    }

    /**
     * Gets an array of ChildCategoryMoretextarea objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMoretextarea is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCategoryMoretextarea[] List of ChildCategoryMoretextarea objects
     * @throws PropelException
     */
    public function getCategoryMoretextareas($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCategoryMoretextareasPartial && !$this->isNew();
        if (null === $this->collCategoryMoretextareas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCategoryMoretextareas) {
                // return empty collection
                $this->initCategoryMoretextareas();
            } else {
                $collCategoryMoretextareas = ChildCategoryMoretextareaQuery::create(null, $criteria)
                    ->filterByMoretextarea($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCategoryMoretextareasPartial && count($collCategoryMoretextareas)) {
                        $this->initCategoryMoretextareas(false);

                        foreach ($collCategoryMoretextareas as $obj) {
                            if (false == $this->collCategoryMoretextareas->contains($obj)) {
                                $this->collCategoryMoretextareas->append($obj);
                            }
                        }

                        $this->collCategoryMoretextareasPartial = true;
                    }

                    reset($collCategoryMoretextareas);

                    return $collCategoryMoretextareas;
                }

                if ($partial && $this->collCategoryMoretextareas) {
                    foreach ($this->collCategoryMoretextareas as $obj) {
                        if ($obj->isNew()) {
                            $collCategoryMoretextareas[] = $obj;
                        }
                    }
                }

                $this->collCategoryMoretextareas = $collCategoryMoretextareas;
                $this->collCategoryMoretextareasPartial = false;
            }
        }

        return $this->collCategoryMoretextareas;
    }

    /**
     * Sets a collection of CategoryMoretextarea objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $categoryMoretextareas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildMoretextarea The current object (for fluent API support)
     */
    public function setCategoryMoretextareas(Collection $categoryMoretextareas, ConnectionInterface $con = null)
    {
        $categoryMoretextareasToDelete = $this->getCategoryMoretextareas(new Criteria(), $con)->diff($categoryMoretextareas);


        $this->categoryMoretextareasScheduledForDeletion = $categoryMoretextareasToDelete;

        foreach ($categoryMoretextareasToDelete as $categoryMoretextareaRemoved) {
            $categoryMoretextareaRemoved->setMoretextarea(null);
        }

        $this->collCategoryMoretextareas = null;
        foreach ($categoryMoretextareas as $categoryMoretextarea) {
            $this->addCategoryMoretextarea($categoryMoretextarea);
        }

        $this->collCategoryMoretextareas = $categoryMoretextareas;
        $this->collCategoryMoretextareasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CategoryMoretextarea objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CategoryMoretextarea objects.
     * @throws PropelException
     */
    public function countCategoryMoretextareas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCategoryMoretextareasPartial && !$this->isNew();
        if (null === $this->collCategoryMoretextareas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCategoryMoretextareas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCategoryMoretextareas());
            }

            $query = ChildCategoryMoretextareaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMoretextarea($this)
                ->count($con);
        }

        return count($this->collCategoryMoretextareas);
    }

    /**
     * Method called to associate a ChildCategoryMoretextarea object to this object
     * through the ChildCategoryMoretextarea foreign key attribute.
     *
     * @param    ChildCategoryMoretextarea $l ChildCategoryMoretextarea
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function addCategoryMoretextarea(ChildCategoryMoretextarea $l)
    {
        if ($this->collCategoryMoretextareas === null) {
            $this->initCategoryMoretextareas();
            $this->collCategoryMoretextareasPartial = true;
        }

        if (!in_array($l, $this->collCategoryMoretextareas->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCategoryMoretextarea($l);
        }

        return $this;
    }

    /**
     * @param CategoryMoretextarea $categoryMoretextarea The categoryMoretextarea object to add.
     */
    protected function doAddCategoryMoretextarea($categoryMoretextarea)
    {
        $this->collCategoryMoretextareas[]= $categoryMoretextarea;
        $categoryMoretextarea->setMoretextarea($this);
    }

    /**
     * @param  CategoryMoretextarea $categoryMoretextarea The categoryMoretextarea object to remove.
     * @return ChildMoretextarea The current object (for fluent API support)
     */
    public function removeCategoryMoretextarea($categoryMoretextarea)
    {
        if ($this->getCategoryMoretextareas()->contains($categoryMoretextarea)) {
            $this->collCategoryMoretextareas->remove($this->collCategoryMoretextareas->search($categoryMoretextarea));
            if (null === $this->categoryMoretextareasScheduledForDeletion) {
                $this->categoryMoretextareasScheduledForDeletion = clone $this->collCategoryMoretextareas;
                $this->categoryMoretextareasScheduledForDeletion->clear();
            }
            $this->categoryMoretextareasScheduledForDeletion[]= clone $categoryMoretextarea;
            $categoryMoretextarea->setMoretextarea(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Moretextarea is new, it will return
     * an empty collection; or if this Moretextarea has previously
     * been saved, it will retrieve related CategoryMoretextareas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Moretextarea.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildCategoryMoretextarea[] List of ChildCategoryMoretextarea objects
     */
    public function getCategoryMoretextareasJoinCategory($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCategoryMoretextareaQuery::create(null, $criteria);
        $query->joinWith('Category', $joinBehavior);

        return $this->getCategoryMoretextareas($query, $con);
    }

    /**
     * Clears out the collFolderMoretextareas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFolderMoretextareas()
     */
    public function clearFolderMoretextareas()
    {
        $this->collFolderMoretextareas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFolderMoretextareas collection loaded partially.
     */
    public function resetPartialFolderMoretextareas($v = true)
    {
        $this->collFolderMoretextareasPartial = $v;
    }

    /**
     * Initializes the collFolderMoretextareas collection.
     *
     * By default this just sets the collFolderMoretextareas collection to an empty array (like clearcollFolderMoretextareas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFolderMoretextareas($overrideExisting = true)
    {
        if (null !== $this->collFolderMoretextareas && !$overrideExisting) {
            return;
        }
        $this->collFolderMoretextareas = new ObjectCollection();
        $this->collFolderMoretextareas->setModel('\MoreTextarea\Model\FolderMoretextarea');
    }

    /**
     * Gets an array of ChildFolderMoretextarea objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMoretextarea is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildFolderMoretextarea[] List of ChildFolderMoretextarea objects
     * @throws PropelException
     */
    public function getFolderMoretextareas($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFolderMoretextareasPartial && !$this->isNew();
        if (null === $this->collFolderMoretextareas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFolderMoretextareas) {
                // return empty collection
                $this->initFolderMoretextareas();
            } else {
                $collFolderMoretextareas = ChildFolderMoretextareaQuery::create(null, $criteria)
                    ->filterByMoretextarea($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFolderMoretextareasPartial && count($collFolderMoretextareas)) {
                        $this->initFolderMoretextareas(false);

                        foreach ($collFolderMoretextareas as $obj) {
                            if (false == $this->collFolderMoretextareas->contains($obj)) {
                                $this->collFolderMoretextareas->append($obj);
                            }
                        }

                        $this->collFolderMoretextareasPartial = true;
                    }

                    reset($collFolderMoretextareas);

                    return $collFolderMoretextareas;
                }

                if ($partial && $this->collFolderMoretextareas) {
                    foreach ($this->collFolderMoretextareas as $obj) {
                        if ($obj->isNew()) {
                            $collFolderMoretextareas[] = $obj;
                        }
                    }
                }

                $this->collFolderMoretextareas = $collFolderMoretextareas;
                $this->collFolderMoretextareasPartial = false;
            }
        }

        return $this->collFolderMoretextareas;
    }

    /**
     * Sets a collection of FolderMoretextarea objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $folderMoretextareas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildMoretextarea The current object (for fluent API support)
     */
    public function setFolderMoretextareas(Collection $folderMoretextareas, ConnectionInterface $con = null)
    {
        $folderMoretextareasToDelete = $this->getFolderMoretextareas(new Criteria(), $con)->diff($folderMoretextareas);


        $this->folderMoretextareasScheduledForDeletion = $folderMoretextareasToDelete;

        foreach ($folderMoretextareasToDelete as $folderMoretextareaRemoved) {
            $folderMoretextareaRemoved->setMoretextarea(null);
        }

        $this->collFolderMoretextareas = null;
        foreach ($folderMoretextareas as $folderMoretextarea) {
            $this->addFolderMoretextarea($folderMoretextarea);
        }

        $this->collFolderMoretextareas = $folderMoretextareas;
        $this->collFolderMoretextareasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FolderMoretextarea objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FolderMoretextarea objects.
     * @throws PropelException
     */
    public function countFolderMoretextareas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFolderMoretextareasPartial && !$this->isNew();
        if (null === $this->collFolderMoretextareas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFolderMoretextareas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFolderMoretextareas());
            }

            $query = ChildFolderMoretextareaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMoretextarea($this)
                ->count($con);
        }

        return count($this->collFolderMoretextareas);
    }

    /**
     * Method called to associate a ChildFolderMoretextarea object to this object
     * through the ChildFolderMoretextarea foreign key attribute.
     *
     * @param    ChildFolderMoretextarea $l ChildFolderMoretextarea
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function addFolderMoretextarea(ChildFolderMoretextarea $l)
    {
        if ($this->collFolderMoretextareas === null) {
            $this->initFolderMoretextareas();
            $this->collFolderMoretextareasPartial = true;
        }

        if (!in_array($l, $this->collFolderMoretextareas->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFolderMoretextarea($l);
        }

        return $this;
    }

    /**
     * @param FolderMoretextarea $folderMoretextarea The folderMoretextarea object to add.
     */
    protected function doAddFolderMoretextarea($folderMoretextarea)
    {
        $this->collFolderMoretextareas[]= $folderMoretextarea;
        $folderMoretextarea->setMoretextarea($this);
    }

    /**
     * @param  FolderMoretextarea $folderMoretextarea The folderMoretextarea object to remove.
     * @return ChildMoretextarea The current object (for fluent API support)
     */
    public function removeFolderMoretextarea($folderMoretextarea)
    {
        if ($this->getFolderMoretextareas()->contains($folderMoretextarea)) {
            $this->collFolderMoretextareas->remove($this->collFolderMoretextareas->search($folderMoretextarea));
            if (null === $this->folderMoretextareasScheduledForDeletion) {
                $this->folderMoretextareasScheduledForDeletion = clone $this->collFolderMoretextareas;
                $this->folderMoretextareasScheduledForDeletion->clear();
            }
            $this->folderMoretextareasScheduledForDeletion[]= clone $folderMoretextarea;
            $folderMoretextarea->setMoretextarea(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Moretextarea is new, it will return
     * an empty collection; or if this Moretextarea has previously
     * been saved, it will retrieve related FolderMoretextareas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Moretextarea.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildFolderMoretextarea[] List of ChildFolderMoretextarea objects
     */
    public function getFolderMoretextareasJoinFolder($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFolderMoretextareaQuery::create(null, $criteria);
        $query->joinWith('Folder', $joinBehavior);

        return $this->getFolderMoretextareas($query, $con);
    }

    /**
     * Clears out the collContentMoretextareas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContentMoretextareas()
     */
    public function clearContentMoretextareas()
    {
        $this->collContentMoretextareas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collContentMoretextareas collection loaded partially.
     */
    public function resetPartialContentMoretextareas($v = true)
    {
        $this->collContentMoretextareasPartial = $v;
    }

    /**
     * Initializes the collContentMoretextareas collection.
     *
     * By default this just sets the collContentMoretextareas collection to an empty array (like clearcollContentMoretextareas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentMoretextareas($overrideExisting = true)
    {
        if (null !== $this->collContentMoretextareas && !$overrideExisting) {
            return;
        }
        $this->collContentMoretextareas = new ObjectCollection();
        $this->collContentMoretextareas->setModel('\MoreTextarea\Model\ContentMoretextarea');
    }

    /**
     * Gets an array of ChildContentMoretextarea objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMoretextarea is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildContentMoretextarea[] List of ChildContentMoretextarea objects
     * @throws PropelException
     */
    public function getContentMoretextareas($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collContentMoretextareasPartial && !$this->isNew();
        if (null === $this->collContentMoretextareas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentMoretextareas) {
                // return empty collection
                $this->initContentMoretextareas();
            } else {
                $collContentMoretextareas = ChildContentMoretextareaQuery::create(null, $criteria)
                    ->filterByMoretextarea($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContentMoretextareasPartial && count($collContentMoretextareas)) {
                        $this->initContentMoretextareas(false);

                        foreach ($collContentMoretextareas as $obj) {
                            if (false == $this->collContentMoretextareas->contains($obj)) {
                                $this->collContentMoretextareas->append($obj);
                            }
                        }

                        $this->collContentMoretextareasPartial = true;
                    }

                    reset($collContentMoretextareas);

                    return $collContentMoretextareas;
                }

                if ($partial && $this->collContentMoretextareas) {
                    foreach ($this->collContentMoretextareas as $obj) {
                        if ($obj->isNew()) {
                            $collContentMoretextareas[] = $obj;
                        }
                    }
                }

                $this->collContentMoretextareas = $collContentMoretextareas;
                $this->collContentMoretextareasPartial = false;
            }
        }

        return $this->collContentMoretextareas;
    }

    /**
     * Sets a collection of ContentMoretextarea objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $contentMoretextareas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildMoretextarea The current object (for fluent API support)
     */
    public function setContentMoretextareas(Collection $contentMoretextareas, ConnectionInterface $con = null)
    {
        $contentMoretextareasToDelete = $this->getContentMoretextareas(new Criteria(), $con)->diff($contentMoretextareas);


        $this->contentMoretextareasScheduledForDeletion = $contentMoretextareasToDelete;

        foreach ($contentMoretextareasToDelete as $contentMoretextareaRemoved) {
            $contentMoretextareaRemoved->setMoretextarea(null);
        }

        $this->collContentMoretextareas = null;
        foreach ($contentMoretextareas as $contentMoretextarea) {
            $this->addContentMoretextarea($contentMoretextarea);
        }

        $this->collContentMoretextareas = $contentMoretextareas;
        $this->collContentMoretextareasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContentMoretextarea objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ContentMoretextarea objects.
     * @throws PropelException
     */
    public function countContentMoretextareas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collContentMoretextareasPartial && !$this->isNew();
        if (null === $this->collContentMoretextareas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentMoretextareas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContentMoretextareas());
            }

            $query = ChildContentMoretextareaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMoretextarea($this)
                ->count($con);
        }

        return count($this->collContentMoretextareas);
    }

    /**
     * Method called to associate a ChildContentMoretextarea object to this object
     * through the ChildContentMoretextarea foreign key attribute.
     *
     * @param    ChildContentMoretextarea $l ChildContentMoretextarea
     * @return   \MoreTextarea\Model\Moretextarea The current object (for fluent API support)
     */
    public function addContentMoretextarea(ChildContentMoretextarea $l)
    {
        if ($this->collContentMoretextareas === null) {
            $this->initContentMoretextareas();
            $this->collContentMoretextareasPartial = true;
        }

        if (!in_array($l, $this->collContentMoretextareas->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContentMoretextarea($l);
        }

        return $this;
    }

    /**
     * @param ContentMoretextarea $contentMoretextarea The contentMoretextarea object to add.
     */
    protected function doAddContentMoretextarea($contentMoretextarea)
    {
        $this->collContentMoretextareas[]= $contentMoretextarea;
        $contentMoretextarea->setMoretextarea($this);
    }

    /**
     * @param  ContentMoretextarea $contentMoretextarea The contentMoretextarea object to remove.
     * @return ChildMoretextarea The current object (for fluent API support)
     */
    public function removeContentMoretextarea($contentMoretextarea)
    {
        if ($this->getContentMoretextareas()->contains($contentMoretextarea)) {
            $this->collContentMoretextareas->remove($this->collContentMoretextareas->search($contentMoretextarea));
            if (null === $this->contentMoretextareasScheduledForDeletion) {
                $this->contentMoretextareasScheduledForDeletion = clone $this->collContentMoretextareas;
                $this->contentMoretextareasScheduledForDeletion->clear();
            }
            $this->contentMoretextareasScheduledForDeletion[]= clone $contentMoretextarea;
            $contentMoretextarea->setMoretextarea(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Moretextarea is new, it will return
     * an empty collection; or if this Moretextarea has previously
     * been saved, it will retrieve related ContentMoretextareas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Moretextarea.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildContentMoretextarea[] List of ChildContentMoretextarea objects
     */
    public function getContentMoretextareasJoinContent($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContentMoretextareaQuery::create(null, $criteria);
        $query->joinWith('Content', $joinBehavior);

        return $this->getContentMoretextareas($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->position = null;
        $this->typobj = null;
        $this->typch = null;
        $this->template_id = null;
        $this->title = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collProductMoretextareas) {
                foreach ($this->collProductMoretextareas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCategoryMoretextareas) {
                foreach ($this->collCategoryMoretextareas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFolderMoretextareas) {
                foreach ($this->collFolderMoretextareas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentMoretextareas) {
                foreach ($this->collContentMoretextareas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collProductMoretextareas = null;
        $this->collCategoryMoretextareas = null;
        $this->collFolderMoretextareas = null;
        $this->collContentMoretextareas = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MoretextareaTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildMoretextarea The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[MoretextareaTableMap::UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
