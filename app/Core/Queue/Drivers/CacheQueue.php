<?php

namespace App\Core\Queue\Drivers;

use App\Core\Cache\Cache;
use App\Core\Facades\CacheFacade;
use App\Core\Queue\Interfaces\JobInterface;
use App\Core\Queue\Interfaces\QueueInterface;

class CacheQueue implements QueueInterface
{
    const string CACHE_KEY_PREFIX = 'queue_jobs_';
    const string LAST_INDEX_KEY = 'queue_last_index';
    const string FIRST_INDEX_KEY = 'queue_first_index';
    public function push(JobInterface $job): void
    {
        $lastIndex = CacheFacade::get(self::LAST_INDEX_KEY, 0);
        $lastIndex++;
        CacheFacade::put(self::CACHE_KEY_PREFIX . $lastIndex, serialize($job));
        CacheFacade::put(self::LAST_INDEX_KEY, $lastIndex);

        // CacheFacade::get(self::LAST_INDEX_KEY); // correct
    }

    public function pop()
    {
        //CacheFacade::get(self::LAST_INDEX_KEY); // return null!

//        CacheFacade::put('test', 1);
//        CacheFacade::get('test'); // correct
        $firstIndex = CacheFacade::get(self::FIRST_INDEX_KEY, 1);
        $job = CacheFacade::get(self::CACHE_KEY_PREFIX . $firstIndex);
        if($job) {
            CacheFacade::forget(self::CACHE_KEY_PREFIX . $firstIndex);
            CacheFacade::put(self::LAST_INDEX_KEY, $firstIndex + 1);
            return unserialize($job);
        }
    }
}
