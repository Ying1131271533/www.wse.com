<?php

use think\cache\driver\Redis;

/**
 * 获取mysql 版本
 * @return string
 */
function getMysqlVersion() {
	// echo config('database.connections.mysql.hostname');
	$conn = mysqli_connect(
		config('database.connections.mysql.hostname') . ":" . config('database.connections.mysql.hostport'),
		config('database.connections.mysql.username'),
		config('database.connections.mysql.password'),
		config('database.connections.mysql.database')
	);

	return mysqli_get_server_info($conn);
}

/**
 * 获取Redis版本
 */
function getRedisVersion()
{
    if (extension_loaded('redis')) {
        try {
            $redis = new Redis();
            $redis->connect('106.52.77.54', 6379);
            $redis->auth(config('app.redis.password'));
            $info = $redis->info();
            return $info['redis_version'];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } else {
        return 'Redis 扩展未安装 ×';
    }
}

/**
 * 获取MongoDB版本
 */
function getMongoVersion()
{
    if (extension_loaded('mongodb')) {
        try {
            $manager = new \MongoDB\Driver\Manager('mongodb://root:123456@mongodb:27017');
            $command = new \MongoDB\Driver\Command(array('serverStatus'=>true));
            $cursor = $manager->executeCommand('admin', $command);
            return $cursor->toArray()[0]->version;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    } else {
        return 'MongoDB 扩展未安装 ×';
    }
}

/**
 * 获取已安装扩展列表
 */
function printExtensions()
{
    echo '<ol>';
    foreach (get_loaded_extensions() as $i => $name) {
        echo "<li>", $name, '=', phpversion($name), '</li>';
    }
    echo '</ol>';
}


//PHP获取磁盘大小
function get_disk_total(int $total) : string
{
    $config = [
        '3' => 'GB',
        '2' => 'MB',
        '1' => 'KB'
    ];
    foreach($config as $key => $value){
        if($total > pow(1024, $key)){
            return round($total / pow(1024,$key)).$value;
        }
        return $total . 'B';
    }
}