<?php

if (!function_exists('logDbQueries')) {
    function logDbQueries($forceDebug = false)
    {
        if (env('DEBUG_LOG_ALL_QUERIES') === 'enabled' || $forceDebug) {
            \DB::listen(function ($query) {
                \Log::debug('---------------- Queries ----------------');

                $data     = compact('bindings', 'time', 'name');
                $sql      = $query->sql;
                $bindings = $query->bindings;

                // Format binding data for sql insertion
                foreach ($bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } elseif (is_string($binding)) {
                        $bindings[$i] = "'$binding'";
                    } elseif (is_numeric($binding)) {
                        $bindings[$i] = "$binding";
                    } elseif (is_bool($binding)) {
                        $bindings[$i] = $binding ? 1 : 0;
                    }
                }

                // Insert bindings into query
                $sql = str_replace(array('%', '?'), array('%%', '%s'), $sql);
                $sql = vsprintf($sql, $bindings);

                \Log::debug($sql, $data);
                \Log::debug(str_repeat('-', 41));
            });
        }
    }
}
