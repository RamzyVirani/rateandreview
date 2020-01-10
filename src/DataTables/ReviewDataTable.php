<?php

namespace RamzyVirani\RateAndReview\DataTables;

use App\Helper\Util;
use RamzyVirani\RateAndReview\Models\Review;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class ReviewDataTable
 * @package Ramzyvirani\RateAndReview\DataTables
 */
class ReviewDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable->editColumn('user.details.full_name', function ($review) {
            return $review->user->details->full_name;
        });
        return $dataTable->addColumn('action', 'rateandreview::datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Review $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = app()->make(config('rateandreview.fqdn.Model'));

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('reviews.create') || \Entrust::hasRole('super-admin')) {
            $buttons = ['create'];
        }
        $buttons = array_merge($buttons, [
            'export',
            'print',
            'reset',
            'reload',
        ]);
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false])
            ->parameters(array_merge(Util::getDataTableParams(), [
                'dom'     => 'Blfrtip',
                'order'   => [[0, 'desc']],
                'buttons' => $buttons,
            ]));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'user.details.full_name' => ['title' => 'User', 'searchable' => false, 'orderable' => false],
            'rating',
            'review'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'reviewsdatatable_' . time();
    }
}