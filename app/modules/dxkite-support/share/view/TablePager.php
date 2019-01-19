<?php
namespace dxkite\support\view;

use suda\archive\Table;
use dxkite\support\view\PageData;
use suda\archive\SQLStatementPrepare;

/**
 * 表页信息构建
 */
class TablePager
{

    /**
     * 选择分页
     *
     * @param Table $table
     * @param string|array $wants
     * @param string|array $where
     * @param array $binder
     * @param integer|null $page
     * @param integer $row
     * @return PageData
     */
    public static function select(Table $table, $wants,  $where, array $binder, ?int $page, int $row):PageData
    {
        $maxRow = conf('pager.max-row', 100);
        $row = $row > $maxRow?$maxRow:$row;
        $rows = $table->select($wants, $where, $binder, $page, $row)->fetchAll();
        $wants = SQLStatementPrepare::prepareWants($wants);
        $where = SQLStatementPrepare::prepareWhere($where, $binder);
        $query = $table->query('SELECT count(*) as count from (SELECT '.$wants.' FROM `%table%` WHERE '.$where.') as total', $binder)->fetch();
        $total = 0;
        if (is_array($query)) {
            $total = intval($query['count']);
        }
        return PageData::build($rows, $total, $page, $row);
    }

    /**
     * 列出指定条件的内容，并进行分页
     *
     * @param Table $table 需要擦好像的表
     * @param string|array $where 查询条件
     * @param array $binder 查询条件值绑定
     * @param integer|null $page 分页
     * @param integer $row 页大小
     * @return PageData
     */
    public static function listWhere(Table $table, $where, array $binder, ?int $page, int $row):PageData
    {
        $maxRow = conf('pager.max-row', 100);
        $row = $row > $maxRow?$maxRow:$row;
        $rows = $table->listWhere($where, $binder, $page, $row);
        $total = $table->count($where, $binder);
        return PageData::build($rows, $total, $page, $row);
    }
    
    /**
     * 搜索页面
     *
     * @param Table $table 需要擦好像的表
     * @param string|array $fields 搜索的列
     * @param string $search 搜索的内容
     * @param string|array $where 查询条件
     * @param array $binder 查询条件值绑定
     * @param integer|null $page 分页
     * @param integer $row 页大小
     * @return PageData
     */
    public static function search(Table $table, $fields, string $search, $where, array $binder, ?int $page, int $row):PageData
    {
        $maxRow = conf('pager.max-row', 100);
        $row = $row > $maxRow?$maxRow:$row;
        $rows = $table->searchWhere($fields, $search, $where, $binder, $page, $row);
        $total = $table->searchWhereCount($fields, $search, $where, $binder);
        return PageData::build($rows, $total, $page, $row);
    }
}