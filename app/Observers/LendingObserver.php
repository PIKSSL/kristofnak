<?php

namespace App\Observers;

use App\Models\Copy;
use App\Models\Lending;

class LendingObserver
{
    /**
     * Handle the Lending "created" event.
     *
     * @param  \App\Models\Lending  $lending
     * @return void
     */
    public function created(Lending $lending)
    {   
        $copy = Copy::where('copy_id', $lending->copy_id)->first();
        $copy->update(['status' => 1]);
    }

    /**
     * Handle the Lending "updated" ev  ent.
     *
     * @param  \App\Models\Lending  $lending
     * @return void
     */
    public function updated(Lending $lending)
    {
        if ($lending->isDirty('end')) {
            $copy = Copy::find($lending->copy_id);
            $copy->status = 0;
            $copy->save();
        }
    }


    /**
     * Handle the Lending "deleted" event.
     *
     * @param  \App\Models\Lending  $lending
     * @return void
     */
    public function deleted(Lending $lending)
    {
        //
    }

    /**
     * Handle the Lending "restored" event.
     *
     * @param  \App\Models\Lending  $lending
     * @return void
     */
    public function restored(Lending $lending)
    {
        //
    }

    /**
     * Handle the Lending "force deleted" event.
     *
     * @param  \App\Models\Lending  $lending
     * @return void
     */
    public function forceDeleted(Lending $lending)
    {
        //
    }
}
