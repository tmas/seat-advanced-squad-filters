<?php

namespace Tmas\AdvancedSquadFilters\Contracts;

use Seat\Web\Models\QueryGroupBuilder;

interface AdvancedFilterContract
{
    public function __construct(stdclass $filterConfig);

    // filter a query of Seat\Eveapi\Models\Character\CharacterInfo, applying
    // conditions to remove characters who don't match the filter criteria.
    public function apply(GroupQueryBuilder $query): GroupQueryBuilder;


    // return a label for the filter, as it will be displayed in the UI
    public static function getLabel(): string;

    // return the fields that are available for configuring the filter.
    // these fields will be used to generate the UI for the filter.
    // fields should use the following format:
    // [
    //     [
    //         'label' => 'Field Label',
    //         'fieldType' => 'text',
    //         'validationType' => 'int',
    //     ],
    //     [
    //         'label' => 'Field Label',
    //         'fieldType' => 'lookup',
    //         'src' => 'seatcore::fastlookup.corporations',
    //     ],
    //     [
    //         'label' => 'Field Label',
    //         'fieldType' => 'dropdown',
    //         'options' => [
    //             'val1' => 'Label 1',
    //             'val2' => 'Label 2',
    //             'val3' => 'Label 3',
    //         ],
    //     ],
    //     [
    //         'label' => 'Field Label',
    //         'fieldType' => 'dropdown',
    //         'options' => [
    //             '<',
    //             '>',
    //         ],
    //     ]
    // ]
    public static function getFields(): array;
}