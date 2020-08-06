<?php

namespace App\Traits;

use App\Models\Language;
use Illuminate\Support\Facades\Schema;

trait CoreBaseModelTrait
{
    /**
     * controller model name
     * @var string
     */
    protected string $modelClass;

    /**
     * You should always use these model names.
     * translation table name (example: CountryTranslation)
     * @var string
     */
    protected string $modelTranslationClass;

    /**
     * table singular name in the database (example: model - Country, $tableSingularName - country)
     * @var string
     */
    protected string $tableSingularName;

    /**
     * table plural name in the database (example: model - Country, $tablePluralName - countries)
     * @var string
     */
    protected string $tablePluralName;

    /**
     * set the initial parameters from the name of the model received from the controller
     * (the name of the model must be indicated in each controller)
     */
    protected function initBaseModel()
    {
        $this->modelClass = static::class;
        $this->modelTranslationClass = $this->modelClass.'Translation';
        $this->setTableSingularName();
        $this->setTablePluralName();
    }


    protected function setTableSingularName(): void
    {
        $camelCaseTableName = lcfirst(substr(strrchr($this->modelClass, "\\"), 1));
        $this->tableSingularName = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $camelCaseTableName)), '_');
    }

    protected function getTableSingularName(): string
    {
        return $this->tableSingularName;
    }

    protected function setTablePluralName(): void
    {
        $this->tablePluralName = $this->modelClass::getTable();
    }

    protected function getTablePluralName(): string
    {
        return $this->tablePluralName;
    }

    /**
     * returns a collection of model records with translations
     * @param int|null $id - to display the specific record
     * @return mixed
     */
    protected function getCollectionsWithTranslate(string $language, int $id = null) {
        $language_id = $this->getLanguageId($language);
        $translationsTableName = $this->tableSingularName.'_translations';

        $query = $this->modelClass::leftJoin(
            $translationsTableName,
            $this->tablePluralName.'.id',
            $translationsTableName.'.'.$this->tableSingularName.'_id'
        )
            ->where($translationsTableName.'.language_id', $language_id)
            ->select($this->tablePluralName.'.*', $translationsTableName.'.name');

        if ($this->isColumnExistInTable('headline', $translationsTableName)) {
            $query->addSelect($translationsTableName.'.headline');
        }
        if ($this->isColumnExistInTable('description', $translationsTableName)) {
            $query->addSelect($translationsTableName.'.description');
        }

        if ($id) {
            $query->where($this->tablePluralName.'.id', $id);
        }

        return $query;
    }

    /**
     * @param int $id - ID record to get
     * @return mixed
     */
    protected function getOneRecord(int $id)
    {
        return $this->modelClass::find($id);
    }

    /**
     * Updates the model and then returns it
     *
     * @param array $modelData - data for updating
     * @param object $model - specific record from the database
     * @return mixed
     */
    protected function updateOneRecord(array $modelData, object $model)
    {
        $filteredModelData = array_filter(
            $modelData,
            fn($key) => in_array($key, $model->getFillable()),
            ARRAY_FILTER_USE_KEY
        );

        $model->fill($filteredModelData);
        $model->save();

        return $model->refresh();
    }

    /**
     * Delete one record
     *
     * @param int $id - ID record to delete
     * @return mixed
     */
    protected function deleteOneRecord(int $id)
    {
        return $this->modelClass::destroy($id);
    }

    /**
     * Check if this record matches this user
     *
     * @param object $model - specific record from the database
     * @param string $columnName - column name to check whether a record matches a specific user
     * @param $valueForColumnName - column value to check whether a record matches a specific user
     * @return bool
     */
    protected function isRecordBelongToUser(object $model, string $columnName, $valueForColumnName): bool {
        return $this->isColumnExistInTable($columnName, $this->getTablePluralName())
            ? $model->{$columnName} === $valueForColumnName
            : false;
    }

    /**
     * Removes array elements by nonexistent columns in the table
     *
     * @param array $params - column names in the table (use for filter 'where')
     * @return array
     */
    protected function filteringForParams(array $params): array {
        return array_filter($params, fn($v, $k) => $this->isColumnExistInTable($k, $this->getTablePluralName()), ARRAY_FILTER_USE_BOTH);
    }

    /**
     * adds to each column in the table the name of the table itself
     * (example: ($tablePluralName - countries, columnName - id) => result - countries.id)
     *
     * @param array $existingTableColumns
     * @return array
     */
    protected function getQueryParams(array $existingTableColumns): array {
        return array_combine(
            array_map(
                fn($k) => $this->tablePluralName. '.' . $k,
                array_keys($existingTableColumns)
            ),
            $existingTableColumns
        );
    }

    /**
     * checking for the existence of column names in the table
     *
     * @param string $columnName - column name in the table
     * @param string $tableName
     * @return bool
     */
    protected function isColumnExistInTable(string $columnName, string $tableName): bool {
        return Schema::hasColumn($tableName, $columnName);
    }

    /**
     * @param $language
     * @return mixed
     */
    protected function getLanguageId($language) {
        return Language::select('id')->where('name', $language)->first()->id;
    }

    /**
     * Get id from request url (example: .../112)
     *
     * @param $request
     * @return int
     */
    protected function getRequestId($request): int {
        return intval($request->route('id'));
    }
}
