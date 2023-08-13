<?php

namespace App\Core;

use App\Core\Database;

class Model
{
    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected static $table ;

    /**
     * The instance of the Database class.
     *
     * @var Database
     */
    protected static $database;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        static::initializeDatabase();
    }

    /**
     * Initialize the database instance.
     *
     * @return void
     */
    protected static function initializeDatabase(): void
    {
        if (!isset(static::$database)) {
            static::$database = new Database();
            static::$database->table(static::$table);
        }
    }

    /**
     * Set the table for the query.
     *
     * @param string $table The name of the table.
     * @return Model
     */
    public static function table(string $table): static
    {
        static::$table = $table;
        return new static();
    }

    /**
     * Set the columns to select.
     *
     * @param array $columns The columns to select.
     * @return Model
     */
    public static function select(array $columns = ['*']): static
    {
        static::initializeDatabase();
        static::$database->table(static::$table)->select($columns);
        return new static();
    }

    /**
     * Add a where clause to the query.
     *
     * @param string $column The column name.
     * @param string $operator The comparison operator.
     * @param mixed $value The value to compare.
     * @return Model
     */
    public static function where(string $column, string $operator, $value): static
    {
        static::initializeDatabase();
        static::$database->where($column, $operator, $value);
        return new static();
    }

    /**
     * Add an order by clause to the query.
     *
     * @param string $column The column to order by.
     * @param string $direction The sort direction (ASC or DESC).
     * @return Model
     */
    public static function orderBy(string $column, string $direction = 'ASC'): static
    {
        static::initializeDatabase();
        static::$database->orderBy($column, $direction);
        return new static();
    }

    /**
     * Set the limit for the query.
     *
     * @param int $limit The maximum number of rows to return.
     * @return Model
     */
    public static function limit(int $limit): static
    {
        static::initializeDatabase();
        static::$database->limit($limit);
        return new static();
    }

    /**
     * Set the offset for the query.
     *
     * @param int $offset The number of rows to skip.
     * @return Model
     */
    public static function offset(int $offset): static
    {
        static::initializeDatabase();
        static::$database->offset($offset);
        return new static();
    }


    /**
     * Retrieves data from the database and returns either an array of model instances or a single model instance.
     *
     * @return static|array Returns an array of model instances if the result is an array, otherwise returns a single model instance.
     */
    public static function get():static | array
    {
        static::initializeDatabase();
        $result = static::$database->get();

        if(is_array($result)) {
            $models = [];
            foreach ($result as  $value) {
                $model = static::createModelInstance(get_called_class());
                $model->fill($value);
                array_push($models, $model);
            }
            return $models;
        }

        $model = static::createModelInstance(get_called_class());

        $model->fill($result);

        return $model;
    }

       /**
     * Execute the select query and return the result set.
     *
     * @return static The result set as an array of appropriate models.
     */
    public static function first():static
    {
        static::initializeDatabase();
        $result = static::$database->first();

        // Get the current class name dynamically
        $className = get_called_class();

        // Create an instance of the appropriate model
        $model = static::createModelInstance($className);

        $model->fill($result);

        return $model;
    }

  /**
     * Create an instance of the appropriate model based on the given class name.
     *
     * @param string $className The class name.
     * @return mixed An instance of the appropriate model.
     */
    private static function createModelInstance(string $className)
    {
        // Get the base class name
        $baseClassName = 'App\Models';

        // Get the current class name without the namespace
        $classParts = explode('\\', $className);
        $currentClassName = end($classParts);

        // Determine the model class name based on the current class name
        $modelName = $baseClassName . '\\' . $currentClassName;

        // Create an instance of the appropriate model
        return new $modelName();
    }

    /**
     * Fill the model with data.
     *
     * @param array $data The data to fill the model with.
     * @return void
     */
    protected function fill(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Execute an insert query and return the last inserted ID.
     *
     * @param array $data The data to insert as an associative array.
     * @return int The last inserted ID.
     */
    public static function insert(array $data): int
    {
        static::initializeDatabase();
        return static::$database->table(static::$table)->insert($data);
    }

    /**
     * Execute an update query and return the number of affected rows.
     *
     * @param array $data The data to update as an associative array.
     * @return int The number of affected rows.
     */
    public static function update(array $data): int
    {
        static::initializeDatabase();
        return static::$database->table(static::$table)->update($data);
    }

    /**
     * Execute a delete query and return the number of affected rows.
     *
     * @return int The number of affected rows.
     */
    public static function delete(): int
    {
        static::initializeDatabase();
        return static::$database->table(static::$table)->delete();
    }

    /**
     * Paginate the query results.
     *
     * @param int $perPage The number of results per page.
     * @param int $page The page number.
     * @return array The paginated result set.
     */
    public static function paginate(int $perPage, int $page = 1): array
    {
        static::initializeDatabase();
        $data = static::$database->table(static::$table)->paginate($perPage, $page);
        if(is_array($data)){
            $models = [];
            foreach ($data as  $value) {
                $model = static::createModelInstance(get_called_class());
                $model->fill($value);
                array_push($models, $model);
            }
            return $models;
        }
        if(is_null($data)){
            $model = static::createModelInstance(get_called_class());
            $model->fill($data);
            return $model;
        }
    }


    /**
     * Returns an array of paginated data from the database table.
     *
     * @param int $perPage The number of items per page (default is 1).
     * @param int $page The current page number (default is 1).
     * @return array An array of model instances representing the paginated data.
     */
    public static function cursorPaginate(int $perPage, int $page = 1): array
    {
        static::initializeDatabase();
        $data = static::$database->table(static::$table)->cursorPaginate($perPage, $page);
        if(is_array($data)){
            $models = [];
            foreach ($data as  $value) {
                $model = static::createModelInstance(get_called_class());
                $model->fill($value);
                array_push($models, $model);
            }
            return $models;
        }
        if(is_null($data)){
            $model = static::createModelInstance(get_called_class());
            $model->fill($data);
            return $model;
        }
    }
}
