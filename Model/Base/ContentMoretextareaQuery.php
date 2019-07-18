<?php

namespace MoreTextarea\Model\Base;

use \Exception;
use \PDO;
use MoreTextarea\Model\ContentMoretextarea as ChildContentMoretextarea;
use MoreTextarea\Model\ContentMoretextareaQuery as ChildContentMoretextareaQuery;
use MoreTextarea\Model\Map\ContentMoretextareaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Content;

/**
 * Base class that represents a query for the 'content_moretextarea' table.
 *
 *
 *
 * @method     ChildContentMoretextareaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildContentMoretextareaQuery orderByContentId($order = Criteria::ASC) Order by the content_id column
 * @method     ChildContentMoretextareaQuery orderByMoretextareaId($order = Criteria::ASC) Order by the moretextarea_id column
 * @method     ChildContentMoretextareaQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildContentMoretextareaQuery orderByChapo($order = Criteria::ASC) Order by the chapo column
 * @method     ChildContentMoretextareaQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildContentMoretextareaQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildContentMoretextareaQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildContentMoretextareaQuery groupById() Group by the id column
 * @method     ChildContentMoretextareaQuery groupByContentId() Group by the content_id column
 * @method     ChildContentMoretextareaQuery groupByMoretextareaId() Group by the moretextarea_id column
 * @method     ChildContentMoretextareaQuery groupByLocale() Group by the locale column
 * @method     ChildContentMoretextareaQuery groupByChapo() Group by the chapo column
 * @method     ChildContentMoretextareaQuery groupByValue() Group by the value column
 * @method     ChildContentMoretextareaQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildContentMoretextareaQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildContentMoretextareaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildContentMoretextareaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildContentMoretextareaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildContentMoretextareaQuery leftJoinMoretextarea($relationAlias = null) Adds a LEFT JOIN clause to the query using the Moretextarea relation
 * @method     ChildContentMoretextareaQuery rightJoinMoretextarea($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Moretextarea relation
 * @method     ChildContentMoretextareaQuery innerJoinMoretextarea($relationAlias = null) Adds a INNER JOIN clause to the query using the Moretextarea relation
 *
 * @method     ChildContentMoretextareaQuery leftJoinContent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Content relation
 * @method     ChildContentMoretextareaQuery rightJoinContent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Content relation
 * @method     ChildContentMoretextareaQuery innerJoinContent($relationAlias = null) Adds a INNER JOIN clause to the query using the Content relation
 *
 * @method     ChildContentMoretextarea findOne(ConnectionInterface $con = null) Return the first ChildContentMoretextarea matching the query
 * @method     ChildContentMoretextarea findOneOrCreate(ConnectionInterface $con = null) Return the first ChildContentMoretextarea matching the query, or a new ChildContentMoretextarea object populated from the query conditions when no match is found
 *
 * @method     ChildContentMoretextarea findOneById(int $id) Return the first ChildContentMoretextarea filtered by the id column
 * @method     ChildContentMoretextarea findOneByContentId(int $content_id) Return the first ChildContentMoretextarea filtered by the content_id column
 * @method     ChildContentMoretextarea findOneByMoretextareaId(int $moretextarea_id) Return the first ChildContentMoretextarea filtered by the moretextarea_id column
 * @method     ChildContentMoretextarea findOneByLocale(string $locale) Return the first ChildContentMoretextarea filtered by the locale column
 * @method     ChildContentMoretextarea findOneByChapo(string $chapo) Return the first ChildContentMoretextarea filtered by the chapo column
 * @method     ChildContentMoretextarea findOneByValue(string $value) Return the first ChildContentMoretextarea filtered by the value column
 * @method     ChildContentMoretextarea findOneByCreatedAt(string $created_at) Return the first ChildContentMoretextarea filtered by the created_at column
 * @method     ChildContentMoretextarea findOneByUpdatedAt(string $updated_at) Return the first ChildContentMoretextarea filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildContentMoretextarea objects filtered by the id column
 * @method     array findByContentId(int $content_id) Return ChildContentMoretextarea objects filtered by the content_id column
 * @method     array findByMoretextareaId(int $moretextarea_id) Return ChildContentMoretextarea objects filtered by the moretextarea_id column
 * @method     array findByLocale(string $locale) Return ChildContentMoretextarea objects filtered by the locale column
 * @method     array findByChapo(string $chapo) Return ChildContentMoretextarea objects filtered by the chapo column
 * @method     array findByValue(string $value) Return ChildContentMoretextarea objects filtered by the value column
 * @method     array findByCreatedAt(string $created_at) Return ChildContentMoretextarea objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildContentMoretextarea objects filtered by the updated_at column
 *
 */
abstract class ContentMoretextareaQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MoreTextarea\Model\Base\ContentMoretextareaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MoreTextarea\\Model\\ContentMoretextarea', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildContentMoretextareaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildContentMoretextareaQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MoreTextarea\Model\ContentMoretextareaQuery) {
            return $criteria;
        }
        $query = new \MoreTextarea\Model\ContentMoretextareaQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildContentMoretextarea|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ContentMoretextareaTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ContentMoretextareaTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildContentMoretextarea A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CONTENT_ID, MORETEXTAREA_ID, LOCALE, CHAPO, VALUE, CREATED_AT, UPDATED_AT FROM content_moretextarea WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildContentMoretextarea();
            $obj->hydrate($row);
            ContentMoretextareaTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildContentMoretextarea|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ContentMoretextareaTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ContentMoretextareaTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the content_id column
     *
     * Example usage:
     * <code>
     * $query->filterByContentId(1234); // WHERE content_id = 1234
     * $query->filterByContentId(array(12, 34)); // WHERE content_id IN (12, 34)
     * $query->filterByContentId(array('min' => 12)); // WHERE content_id > 12
     * </code>
     *
     * @see       filterByContent()
     *
     * @param     mixed $contentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByContentId($contentId = null, $comparison = null)
    {
        if (is_array($contentId)) {
            $useMinMax = false;
            if (isset($contentId['min'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::CONTENT_ID, $contentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($contentId['max'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::CONTENT_ID, $contentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::CONTENT_ID, $contentId, $comparison);
    }

    /**
     * Filter the query on the moretextarea_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMoretextareaId(1234); // WHERE moretextarea_id = 1234
     * $query->filterByMoretextareaId(array(12, 34)); // WHERE moretextarea_id IN (12, 34)
     * $query->filterByMoretextareaId(array('min' => 12)); // WHERE moretextarea_id > 12
     * </code>
     *
     * @see       filterByMoretextarea()
     *
     * @param     mixed $moretextareaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByMoretextareaId($moretextareaId = null, $comparison = null)
    {
        if (is_array($moretextareaId)) {
            $useMinMax = false;
            if (isset($moretextareaId['min'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::MORETEXTAREA_ID, $moretextareaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moretextareaId['max'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::MORETEXTAREA_ID, $moretextareaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::MORETEXTAREA_ID, $moretextareaId, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the chapo column
     *
     * Example usage:
     * <code>
     * $query->filterByChapo('fooValue');   // WHERE chapo = 'fooValue'
     * $query->filterByChapo('%fooValue%'); // WHERE chapo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $chapo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByChapo($chapo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($chapo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $chapo)) {
                $chapo = str_replace('*', '%', $chapo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::CHAPO, $chapo, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ContentMoretextareaTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentMoretextareaTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \MoreTextarea\Model\Moretextarea object
     *
     * @param \MoreTextarea\Model\Moretextarea|ObjectCollection $moretextarea The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByMoretextarea($moretextarea, $comparison = null)
    {
        if ($moretextarea instanceof \MoreTextarea\Model\Moretextarea) {
            return $this
                ->addUsingAlias(ContentMoretextareaTableMap::MORETEXTAREA_ID, $moretextarea->getId(), $comparison);
        } elseif ($moretextarea instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContentMoretextareaTableMap::MORETEXTAREA_ID, $moretextarea->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMoretextarea() only accepts arguments of type \MoreTextarea\Model\Moretextarea or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Moretextarea relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function joinMoretextarea($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Moretextarea');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Moretextarea');
        }

        return $this;
    }

    /**
     * Use the Moretextarea relation Moretextarea object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MoreTextarea\Model\MoretextareaQuery A secondary query class using the current class as primary query
     */
    public function useMoretextareaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMoretextarea($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Moretextarea', '\MoreTextarea\Model\MoretextareaQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Content object
     *
     * @param \Thelia\Model\Content|ObjectCollection $content The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function filterByContent($content, $comparison = null)
    {
        if ($content instanceof \Thelia\Model\Content) {
            return $this
                ->addUsingAlias(ContentMoretextareaTableMap::CONTENT_ID, $content->getId(), $comparison);
        } elseif ($content instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContentMoretextareaTableMap::CONTENT_ID, $content->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByContent() only accepts arguments of type \Thelia\Model\Content or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Content relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function joinContent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Content');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Content');
        }

        return $this;
    }

    /**
     * Use the Content relation Content object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ContentQuery A secondary query class using the current class as primary query
     */
    public function useContentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Content', '\Thelia\Model\ContentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildContentMoretextarea $contentMoretextarea Object to remove from the list of results
     *
     * @return ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function prune($contentMoretextarea = null)
    {
        if ($contentMoretextarea) {
            $this->addUsingAlias(ContentMoretextareaTableMap::ID, $contentMoretextarea->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the content_moretextarea table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContentMoretextareaTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContentMoretextareaTableMap::clearInstancePool();
            ContentMoretextareaTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildContentMoretextarea or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildContentMoretextarea object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContentMoretextareaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ContentMoretextareaTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ContentMoretextareaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ContentMoretextareaTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ContentMoretextareaTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ContentMoretextareaTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContentMoretextareaTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContentMoretextareaTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContentMoretextareaTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildContentMoretextareaQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContentMoretextareaTableMap::CREATED_AT);
    }

} // ContentMoretextareaQuery
