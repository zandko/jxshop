
namespace models;

class <?=$mname?> extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = "<?=$tableName?>";
    protected $fillable = ["<?=$fillable?>"];
}
