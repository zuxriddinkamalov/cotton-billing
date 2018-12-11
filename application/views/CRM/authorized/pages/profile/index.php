<?php $this->load->view('CRM/authorized/components/grid_header');?>
<script src="<?= base_url() ?>assets/js/highcharts.js"></script>
<script src="<?= base_url() ?>assets/js/highcharts-3d.js"></script> 
<style>
input[readonly]
{
    background-color:#e6e6e6;
}
</style>
<div class="container">  
<?php if($profile){?>
    <div class="profile">
   

     <div class="col-md-12 " style="padding: 0;">
<div class="panel panel-default">
  <div class="panel-heading">  
  <h4><?=$profile->first_name?> <?=$profile->last_name?></h4>
  <div class="menu-profile">
    <ul class="list-unstyled">
    <li><a href="#" data-toggle="modal" data-target="#contact_info"><i class="fa fa-address-card-o" aria-hidden="true"></i> Контактные данные </a></li>
     <li><a href="#"  data-toggle="collapse" data-target="#stat"><i class="fa fa-pie-chart" aria-hidden="true"></i> Статистика</a></li>
    
        <li><a href="#" data-toggle="modal" data-target="#importClient"><i class="fa fa-download" aria-hidden="true"></i> Импорт</a> / Экспорт: &nbsp; <a href="<?=base_url('profile/exportExcel/'.$client_id)?>" rel="nofollow"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a> &nbsp; <a href="<?=base_url('profile/exportPDF/'.$client_id)?>" rel="nofollow"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a></li>
         
    </ul>
  </div>
  <div class="clearfix"></div>
  </div>

    </div>
</div>  
<div class="clearfix"></div>
  <div id="stat" class="collapse">
  <div class="pull-right">
  <a href="#"  data-toggle="collapse" data-target="#stat"><i class="fa fa-times" aria-hidden="true"></i> Закрыть</a>
  </div>
  <div class="clearfix"></div>
    <?php if($total_price || $paid_sum || $trade_receivable){?>
     <div id="container_pie"></div>
         <script>
                        Highcharts.chart('container_pie', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        },
        backgroundColor: null
    },
    title: {
        text: 'Статистика'
    },
    subtitle: {
       // text: '3D donut in Highcharts'
    },
    exporting: {
         enabled: false
},    
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            innerSize: 100,
            depth: 45,
            dataLabels: {
            enabled: true,           
            style: { fontFamily: '\'OpenSans\', sans-serif', lineHeight: '18px', fontSize: '17px' }
        }
        }
    },
    colors:[
       '#02a2dc',
        '#fcbf4a',
        '#808080',
        '#ff0000',
       '#58b182',
       '#58AA82',
       '#BAb182'
    ],
    series: [{
        name: '',    
   
        data: [
            
            ['Итого Цена: <?=number_format($total_price, 0, ',', ' ');?>',  <?=$total_price?>],
            ['Отдал: <?=number_format($paid_sum, 0, ',', ' ');?>',  <?=$paid_sum?>],
            ['Задолженность: <?=number_format($trade_receivable, 0, ',', ' ');?>',  <?=$trade_receivable?>],
                     
        ]
    }]
});
                        </script> 
                        
                        <?php } else {?> 
                        <div class="alert alert-danger" style="font-size: 16px; text-align: center;">
  Нет данных!
</div>
                        <?php }?>
                        
  </div>
<div class="clearfix"></div>
    </div> 
	<div id="salesGrid"></div>
	<script>
              $(function() {
               

var DateField = function(config) {
    jsGrid.Field.call(this, config);
};

DateField.prototype = new jsGrid.Field({
    sorter: function(date1/*, date2*/) {
        return new Date(date1)/* - new Date(date2)*/;
    },    
    
   /* itemTemplate: function(value) {
        return new Date(value).toDateString();
    },*/
    
    filterTemplate: function() {
        var grid = this._grid;
        var now = new Date();
        // defaultDate: now.setFullYear(now.getFullYear() - 1),
        this._fromPicker = $("<input>").datepicker({  dateFormat: 'yy-mm-dd' });
       // this._toPicker = $("<input>").datepicker({ defaultDate: now.setFullYear(now.getFullYear() + 1) });
         this._fromPicker.on("change", function(e) {        
            grid.search();       
         });
        return $(this._fromPicker);//.append(this._toPicker);
 
    },
    
  /*  insertTemplate: function(value) {
        return this._insertPicker = $("<input>").datepicker({ defaultDate: new Date() });
    },
    
    editTemplate: function(value) {
        return this._editPicker = $("<input>").datepicker().datepicker("setDate", new Date(value));
    },
    
    insertValue: function() {
        return this._insertPicker.datepicker("getDate").toISOString();
    },
    
    editValue: function() {
        return this._editPicker.datepicker("getDate").toISOString();
    },*/
    
    filterValue: function() {
         var date = this._fromPicker.datepicker("getDate");
         return $.datepicker.formatDate("yy-mm-dd", date);
         
       /* return {
            // from: this._fromPicker.datepicker("getDate"),          
            //to: this._toPicker.datepicker("getDate")
        };*/
      
    }
});


jsGrid.fields.date = DateField;
        	<?php if(LANG!="en"){?>jsGrid.locale("<?=LANG?>");<?php }?>
            $("#salesGrid").jsGrid({
                height: 'auto',
                width: "100%",
                filtering: true,
                sorting: false,
                paging: true,
				editing: true,
                inserting: true,
                pageSize: 50,
                autoload: true,
                //selecting: false,
                pageIndex: 1,
                onItemEditing: function(args) {
                    //console.log($('.delete-checker[data-value='+args.item.client_id+']').is(":checked"));
                    window.setTimeout(function(){
                        $('.delete-checker[data-value='+args.item.client_id+']').is(":checked") ? $('.edit-delete-checker[data-value='+args.item.client_id+']').prop('checked', true) : $('.edit-delete-checker[data-value='+args.item.client_id+']').prop('checked', false);
                    }, 10);
                },
              //  pageCount: <?=$countSale?>,       
                pageButtonCount: 5,
                pageLoading: true,        
                controller: {     
                    loadData: function(filter){
		    	    var deferred = $.Deferred();
			         $.ajax({
			            type: "get",
			            url: "<?=base_url('profile/profileProduct/'.$client_id)?>",
			            data: filter,
			            dataType:"json",
			            success:function(datas){
			        	// debugger
			        	  var da = {
			        		data :datas.data,
			        		itemsCount : datas.countSale
			        	  };
                          for(var i=0; i<da.data.length; i++){
                            da.data[i].paid_sum = parseFloat(da.data[i].paid_sum);//.toFixed(2);
                            da.data[i].price_per_one = parseFloat(da.data[i].price_per_one);//.toFixed(2);
                            da.data[i].total_price = parseFloat(da.data[i].total_price);//.toFixed(2);
                            da.data[i].trade_receivable = parseFloat(da.data[i].trade_receivable);//.toFixed(2);
                          }                          
			        	  deferred.resolve(da);
			        }
			        });
			        return deferred.promise();  
                    },                 
                    insertItem: function(item) {
                        return $.ajax({
                            type: "POST",
                            url: "<?=base_url('profile/addProduct/'.$client_id)?>",
                            data: item
                        });
                    },
                    updateItem: function(item) {
                         return $.ajax({
                            type: "POST",
                            url: "<?=base_url('product/update_products')?>",
                            data: item,
                            success: function(data){
                                 $("#salesGrid").jsGrid({});
                            },
                        });                  
                    },
                deleteItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "<?=base_url('product/delete')?>",
                        data: item
                    });
                },
                },
                fields: [  
                {
            headerTemplate: function() {
                var el = $("<div class='remove-header'>");         //       
                el.append($("<button class='btn-delete-all'>").attr("type", "button").html('<i class="fa fa-trash-o" aria-hidden="true"></i>').addClass("btn btn-primary mr-1").on("click", function() {
                    remove_sales();
                }));
                el.append($("<input type='checkbox' class='select-all' onchange='select_all(event)'>"));
                return el;
            },
            itemTemplate: function(_, item) {
                return $("<input class='delete-checker' onchange='unselectMain(event)' data-value="+item.client_id+">").attr("type", "checkbox").prop("checked", $.inArray(item, selectedItems) > -1).on("change", function() {
                    $(this).is(":checked") ? selectItem(item) : unselectItem(item)
                });
            },
            editTemplate: function(_, item) {
                return $("<input class='edit-delete-checker' onchange='unselectMain(event)' data-value="+item.client_id+">").attr("type", "checkbox").on("change", function() {
                    $(this).is(":checked") ? $('.delete-checker[data-value='+item.client_id+']').prop('checked', true) : $('.delete-checker[data-value='+item.client_id+']').prop('checked', false);
                });                
            },
            align: "center",
            width: 38,
            editing: false,
        },                
                   // { name: "first_name", title: "Имя", type: "text", /*validate: "required",*/  inserting: false, editing: false, filtering: false,  
                        /*itemTemplate: function(value, item) {
                            return $("<a class='client-info'>").attr("href", '<?=base_url(LANG.'/profile/')?>'+item.client_id).text(value);
                        }*/
                   // },
                  // { name: "last_name", title: "Фамилия", type: "text", /*validate: "required",*/ inserting: false, editing: false, filtering: false, },
                  //  { name: "company", title: "Компания", type: "text", /*validate: "required",*/ inserting: false, editing: false, filtering: false, },*/
                    { name: "date", title: "Дата", type: "date" },
                    { name: "price_per_one", title: "Цена за 1 кг", type: "number", validate: "required" },
                    { name: "weight", title: "Вес кг", type: "number", validate: "required" },
                    { name: "total_price", title: "Итого Цена",  type: "number", filtering: true, inserting: false, editing: false,},
                    { name: "paid_sum", title: "Отдал", type: "number", validate: "required" },
                    { name: "trade_receivable", title: "Задолженность", type: "number", filtering: true, inserting: false, editing: false,},
                    { type: "control" }
                ]
            });
        });
            var selectedItems = [],
        selectItem = function(item) {
            selectedItems.push(item)
        },
        unselectItem = function(item) {
            selectedItems = $.grep(selectedItems, function(i) {
                return i !== item
            })
        },
        select_all = function(event){
            if($(event.target).prop('checked')){
                $('.delete-checker').prop('checked', true);
            } else {                
                $('.delete-checker').prop('checked', false);
            }
        },
        unselectMain = function(event){
            var is_all_selected = true;
            $(".delete-checker").each(function(index, element){
                if(!$(element).prop('checked'))
                    is_all_selected = false;
            });
            if(is_all_selected)
                $('.select-all').prop('checked', true);
            else
                $('.select-all').prop('checked', false);
        },
        remove_sales = function(){
            if (selectedItems.length && confirm("Вы уверены?")) {
                $(".delete-checker").each(function(index, element){
                    if($(element).prop('checked'))
                        $.ajax({
                          url: '<?=base_url('product/delete')?>',
                          type: "POST",
                          data: {client_id: $(element).attr('data-value')},
                          success: function(){
                            $("#salesGrid").jsGrid({}); 
                          }
                        });
                });
               
            }           
        };
        $('#salesGrid .jsgrid-edit-row .jsgrid-cell').on('keypress','input', function (e) {
            //alert('hello world');
          if (e.which == 13) {
            $("#salesGrid").jsGrid("updateItem");
            return false;
          }
        });
       
    	$(document).click( function(event){
          if( $(event.target).closest('#salesGrid').length ) 
        	return;
          //$("#salesGrid").jsGrid("refresh");
          $("#salesGrid").jsGrid("cancelEdit");
           $("#salesGrid").jsGrid("clearFilter");
          event.stopPropagation();
        });
 
    </script>
      <div id="contact_info" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Контактные данные</h4>
      </div>
      <div class="modal-body">
            <ul class="list-unstyled">
             <li><span>Компания:</span> <?=$profile->company?></li>
             <li><span>Адрес:</span> <?=$profile->adress?></li>
             <li><span>Телефон:</span> <a href="tel:<?=$profile->phone?>"><?=$profile->phone?></a></li>
             <li><span>E-mail:</span> <a href="mailto:<?=$profile->email?>"><?=$profile->email?></a></li>
            </ul>
      </div>     
    </div>

  </div>
</div>
<div id="importClient" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Импорт</h4>
      </div>
      <div class="modal-body">
           
    <div class="import">
        <?php echo form_open_multipart('profile/importExcel/'.$client_id); ?>
        <input type="file" name="userfile" required="required" class="file-export" />
        <?php echo form_submit('submit', 'Импорт', 'class="btn btn-primary"') ?>
        <a href="<?=base_url('uploads/import_clients.xls')?>" style="margin-left: 15px">Скачать шаблон</a>   
        <?php echo form_close(); ?>
    </div>
      </div>      
    </div>

  </div>
</div>
    
    <?php } else {?>
    <div class="alert alert-danger" style="font-size: 16px; text-align: center;">
  Профиль не найден
</div>
    
    <?php }?>
</div>