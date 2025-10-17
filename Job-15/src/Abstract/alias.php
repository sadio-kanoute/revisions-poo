<?php
if (!class_exists('App\\Abstract\\AbstractProduct') && class_exists('AbstractProduct')) {
    class_alias('AbstractProduct', 'App\\Abstract\\AbstractProduct');
}
