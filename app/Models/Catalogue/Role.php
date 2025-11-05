<?php

namespace App\Models\Catalogue;

use App\Models\Personnel\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

       protected $appends = [ 'selectedpermissions','status_name', 'total'];


      public function getTotalAttribute()
      {
          $id = $this->attributes['id'];
          $count = Administrator::where('role_id', $id)->count() ?: 0;

          return  $this->attributes['total'] = $count;
      }

      public function getSelectedPermissionsAttribute()
      {
          $selectedPermissions = [];
          $id = $this->id;

          $getPermissions = @RolePermission::select('permission')->where('role_id', $id)->get();
          if ($getPermissions->isNotEmpty()) {
              foreach ($getPermissions as $key => $permm) {
                  $selectedPermissions[] = $permm->permission;
              }
          }
          return $this->attributes['selectedpermissions'] =  $selectedPermissions;
      }

      public function getStatusNameAttribute()
      {
          $statusName = '';
          $getStatus = $this->status;
          if ($getStatus == 0) {
              $statusName = 'Inactive';
          } elseif ($getStatus == 1) {
              $statusName = 'Active';
          }
          return $this->attributes['status_name'] = $statusName;
      }
}
