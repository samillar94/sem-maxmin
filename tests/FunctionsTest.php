<?php
use App\Functions;
use PHPUnit\Framework\TestCase;

## TODO adapt percent -> sort

class FunctionsTest extends TestCase {

    public function provideExtractDataValid() {
        return [
            array(
                array(
                    'sorted_item_1' => "Lecture sessions",
                    'sorted_item_2' => "Lab sessions",
                    'sorted_item_3' => "Support sessions",
                    'sorted_item_4' => "Canvas activities",
                    'sorted_attendance_1' => 0,
                    'sorted_attendance_2' => 0,
                    'sorted_attendance_3' => 0,
                    'sorted_attendance_4' => 0,
                    'sorted_unit_1' => "hours",
                    'sorted_unit_2' => "hours",
                    'sorted_unit_3' => "hours",
                    'sorted_unit_4' => "hours",
                ),
                array(
                    0 => array(
                        'item' => "Lecture sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ),
                    1 => array(
                        'item' => "Lab sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ),
                    2 => array(
                        'item' => "Support sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ),
                    3 => array(
                        'item' => "Canvas activities",
                        'attendance' => 0,
                        'unit' => "hours"
                    ) 
                )
            ),
            array(
                array(
                    'sorted_item_1' => "Canvas activities",
                    'sorted_item_2' => "Support sessions",
                    'sorted_item_3' => "Lab sessions",
                    'sorted_item_4' => "Lecture sessions",
                    'sorted_attendance_1' => 55,
                    'sorted_attendance_2' => 10,
                    'sorted_attendance_3' => 1,
                    'sorted_attendance_4' => 0,
                    'sorted_unit_1' => "hours",
                    'sorted_unit_2' => "hours",
                    'sorted_unit_3' => "hours",
                    'sorted_unit_4' => "hours",
                ),
                array(
                    0 => array(
                        'item' => "Canvas activities",
                        'attendance' => 55,
                        'unit' => "hours"
                    ),
                    1 => array(
                        'item' => "Support sessions",
                        'attendance' => 10,
                        'unit' => "hours"
                    ),
                    2 => array(
                        'item' => "Lab sessions",
                        'attendance' => 1,
                        'unit' => "hours"
                    ),
                    3 => array(
                        'item' => "Lecture sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ),
                )
            ),
            array(
                array(
                    'sorted_foo' => "sorted_bar",
                    'sorted_item_1' => "Labs",
                    'sorted_item_2' => "Canvas",                
                    'sorted_item_3' => "Lectures",
                    'sorted_item_4' => "Support",
                    'sorted_attendance_1' => 22.5,
                    'sorted_attendance_2' => 22.5,
                    'sorted_attendance_3' => 4,
                    'sorted_attendance_4' => 0,
                    'sorted_unit_1' => "h",
                    'sorted_unit_2' => "h",
                    'sorted_unit_3' => "h",
                    'sorted_unit_4' => "h",
                ),
                array(
                    0 => array(
                        'item' => "Labs",
                        'attendance' => 22.5,
                        'unit' => "h"
                    ),
                    1 => array(
                        'item' => "Canvas",
                        'attendance' => 22.5,
                        'unit' => "h"
                    ),
                    2 => array(
                        'item' => "Lectures",
                        'attendance' => 4,
                        'unit' => "h"
                    ),
                    3 => array(
                        'item' => "Support",
                        'attendance' => 0,
                        'unit' => "h"
                    )
                )
            ),
            array(
                array(
                    'sorted_item_1' => "Labs",
                    'sorted_item_2' => "Lectures",
                    'sorted_attendance_1' => 22,
                    'sorted_attendance_2' => 4,
                    'sorted_unit_1' => "hours",
                    'sorted_unit_2' => "hours",
                ),
                array(
                    0 => array(
                        'item' => "Labs",
                        'attendance' => 22,
                        'unit' => "hours"
                    ),
                    1 => array(
                        'item' => "Lectures",
                        'attendance' => 4,
                        'unit' => "hours"
                    ),
                )
            )
        ];
    }

    public function provideExtractDataDiffCounts() {
        return [
            array(
                array(
                    'item_1' => "Lectures",
                    'item_2' => "Labs",
                    'item_3' => "Support",
                    'item_4' => "Canvas",                
                    'attendance_1' => 1,
                    'attendance_2' => 0,
                    'unit_1' => "h",
                    'unit_2' => "h",
                    'unit_3' => "h",
                    'unit_4' => "h"
                )
            ),
            array(
                array(
                    'item_1' => "Lectures",
                    'item_2' => "Labs",
                    'item_3' => "Support",
                    'item_4' => "Canvas",                
                    'attendance_1' => 55,
                    'attendance_2' => 10,
                    'attendance_3' => 1,
                    'attendance_4' => 0,
                    'unit_1' => "h",
                    'unit_2' => "h",
                    'unit_3' => "h"
                )
            ),
            array(
                array(
                    'item_1' => "Lectures",            
                    'attendance_1' => 55,
                    'attendance_2' => 10,
                    'attendance_3' => 1,
                    'attendance_4' => 0,
                    'unit_1' => "h",
                    'unit_2' => "h",
                    'unit_3' => "h",
                    'unit_4' => "h"
                )
            ),
            array(
                array(
                    'item_1' => "Lectures",
                    'item_2' => "Labs",
                    'item_3' => "Support",
                    'item_4' => "Canvas",                
                    'attendance_1' => 55,
                    'attendance_2' => 10,
                    'attendance_3' => 1,
                    'attendance_4' => 0,
                )
            )
        ];
    }

    public function provideBuildResultsValid() {
        return [
            [
                array(
                    0 => array(
                        'item' => "Lecture sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ),
                    1 => array(
                        'item' => "Lab sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ),
                    2 => array(
                        'item' => "Support sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ),
                    3 => array(
                        'item' => "Canvas activities",
                        'attendance' => 0,
                        'unit' => "hours"
                    ) 
                ),
                array(
                    "error" => false,
                    "data" => array(
                        "max_attendances" => [                 
                            0 => array(
                                'item' => "Lecture sessions",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                            1 => array(
                                'item' => "Lab sessions",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                            2 => array(
                                'item' => "Support sessions",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                            3 => array(
                                'item' => "Canvas activities",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                        ],
                        "min_attendances" => [
                            0 => array(
                                'item' => "Lecture sessions",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                            1 => array(
                                'item' => "Lab sessions",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                            2 => array(
                                'item' => "Support sessions",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                            3 => array(
                                'item' => "Canvas activities",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                        ]
                    ),
                    "lines" => array(
                        0 => 'All attendances equal',
                    )
                )
            ],
            [
                array(
                    0 => array(
                        'item' => "Canvas activities",
                        'attendance' => 55,
                        'unit' => "hours"
                    ),
                    1 => array(
                        'item' => "Support sessions",
                        'attendance' => 10,
                        'unit' => "hours"
                    ),
                    2 => array(
                        'item' => "Lab sessions",
                        'attendance' => 1,
                        'unit' => "hours"
                    ),
                    3 => array(
                        'item' => "Lecture sessions",
                        'attendance' => 0,
                        'unit' => "hours"
                    ), 
                ),
                array(
                    "error" => false,
                    "data" => array(
                        "max_attendances" => [                 
                            0 => array(
                                'item' => "Canvas activities",
                                'attendance' => 55,
                                'unit' => "hours"
                            ),
                        ],
                        "min_attendances" => [
                            0 => array(
                                'item' => "Lecture sessions",
                                'attendance' => 0,
                                'unit' => "hours"
                            ),
                        ],
                    ),
                    "lines" => [
                        0 => 'Maximum attendance:',
                        1 => '- Canvas activities: 55 hours',
                        2 => 'Minimum attendance:',
                        3 => '- Lecture sessions: 0 hours'
                    ]
                )
            ],
            [
                array(
                    0 => array(
                        'item' => "Labs",
                        'attendance' => 22.5,
                        'unit' => "h"
                    ),
                    1 => array(
                        'item' => "Canvas",
                        'attendance' => 22.5,
                        'unit' => "h"
                    ),
                    2 => array(
                        'item' => "Lectures",
                        'attendance' => 4,
                        'unit' => "h"
                    ),
                    3 => array(
                        'item' => "Support",
                        'attendance' => 0,
                        'unit' => "h"
                    )
                ),
                array(
                    "error" => false,
                    "data" => array(
                        "max_attendances" => [                 
                            0 => array(
                                'item' => "Labs",
                                'attendance' => 22.5,
                                'unit' => "h"
                            ),
                            1 => array(
                                'item' => "Canvas",
                                'attendance' => 22.5,
                                'unit' => "h"
                            ),
                        ],
                        "min_attendances" => [
                            0 => array(
                                'item' => "Support",
                                'attendance' => 0,
                                'unit' => "h"
                            ),
                        ],
                    ),
                    "lines" => [
                        0 => 'Maximum attendances:',
                        1 => '- Labs: 23 h',
                        2 => '- Canvas: 23 h',
                        3 => 'Minimum attendance:',
                        4 => '- Support: 0 h',
                    ]
                )
            ]
        ];
    }

    /**
     * @dataProvider provideExtractDataValid
     */
    public function testExtractDataValid($inputArray, $expectedArray) {

        $functions = new Functions();

        $actual = $functions->extractData($inputArray);
        echo print_r($actual, true);
        $this->assertEquals($expectedArray, $actual);

    }

    /**
     * @dataProvider provideExtractDataDiffCounts
     */
    public function testExtractDataDiffCounts($inputArray) {

        $functions = new Functions();

        $this->expectException(\Exception::class);
        $actual = $functions->extractData($inputArray);

    }

    /**
     * @dataProvider provideBuildResultsValid
     */
    public function testBuildResultsValid($inputArray, $expectedArray) {

        $functions = new Functions();

        $actual = $functions->BuildResults($inputArray);
        echo print_r($actual, true);
        $this->assertEquals($expectedArray, $actual);

    }
};

?>