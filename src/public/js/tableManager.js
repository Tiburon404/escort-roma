/**
 * @namespace arcadia
 *
 */
(function() {

    var ns = escort;

    ns.tableManager = function (table,delColumn,modColumn,callbackMio){
        this._table=$('#'+table).DataTable({
            "rowCallback": callbackMio
        });




       /* var tableA=this._table;
        this._table.on( 'click', 'td',callbackMio);

            /*this._table.on( 'click', 'td', function () {

            var data = tableA.cell( this ).index();
            var rowData = tableA.row( data.row ).data();

            if (data.column === delColumn ){
                console.log("Elimina");
            }else if(data.column === modColumn){
                console.log("Modifica");
            }

            console.log(data);
            console.log(rowData);

        });*/

    };


})();