var machineTable = $('#dataMachineTable').DataTable();
var addModButton = $('#addModButton');


/*======================================
  Gestione Finestra Modale Eliminazione
 *======================================*/

$('#confirmDeleteMachine').on('show.bs.modal', function(e) {

    $('#btn_del_machine').on('click', function() {

        $("#canDelete").val(1);
        $('#confirmDeleteMachine').modal('hide');
        var idMachine = $("#idMachine").val();
        var rowNum = $("#rowNum").val();
        var data = {
            "message": {
                "action": "delMachine",
                "idUtente": 1,
                "data": {
                    "id": parseInt(idMachine),
                    "rowNum": rowNum
                }
            }
        };
        dataManagerA.setData(data);
        dataManagerA.send(gestEsitoDel);

    });

});

/**
 *
 * @param dataReturn
 */
function gestEsitoDel(dataReturn) {
    if (dataReturn.ESITO.number === 0) {

        infoDialog.showDialog('SUCCESS', 'Macchina Eliminata', '', infoDialog.errorType.SUCCESS);

        machineTable.rows($("#rowNum").val()).remove().draw(true);

    } else {
        infoDialog.showDialog('ERROR', dataReturn.ESITO.description, dataReturn.ESITO.MESSAGE, infoDialog.errorType.ERROR);
    }

}

/**
 *
 * @param dataReturn
 */
function gestEsitoMod(dataReturn) {
    if (dataReturn.ESITO.number === 0) {

        infoDialog.showDialog('SUCCESS', 'Macchina Modificata', '', infoDialog.errorType.SUCCESS);

    } else {

        infoDialog.showDialog('ERROR', dataReturn.ESITO.description, dataReturn.MESSAGE, infoDialog.errorType.ERROR);

    }

}

/**
 *
 * @param dataReturn
 */
function gestEsitoAdd(dataReturn) {
    if (dataReturn.ESITO.number === 0) {

        infoDialog.showDialog('SUCCESS', 'Macchina Aggiunta', '', infoDialog.errorType.SUCCESS);

    } else {

        infoDialog.showDialog('ERROR', dataReturn.ESITO.description, dataReturn.MESSAGE, infoDialog.errorType.ERROR);

    }

}


/**
 * Aggiunta/Modifica Macchina
 */

addModButton.on('click', function(event) {
    var typeAction = $('#actionMod').val();

    if (typeAction === "1") {

        var data = {
            "message": {
                "action": "modMachine",
                "idUtente": 1,
                "data": {
                    "idMachine": parseInt($("#idMachine").val()),
                    "idFarm": 0,
                    "name": $('#machine_name').val(),
                    "description": $('#machine_description').val(),
                    "radiusCurve": $('#machine_curve_angle').val(),
                    "driveShaft": $('#machine_drive_shaft').val(),
                    "fullSpeed": $('#machine_max_speed').val()
                }
            }
        }

        dataManagerA.setData(data);
        dataManagerA.send(gestEsitoMod);

    } else {
        var data = {
            "message": {
                "action": "addMachine",
                "idUtente": 1,
                "data": {
                    "idFarm": 0,
                    "name": $('#machine_name').val(),
                    "description": $('#machine_description').val(),
                    "radiusCurve": $('#machine_curve_angle').val(),
                    "driveShaft": $('#machine_drive_shaft').val(),
                    "fullSpeed": $('#machine_max_speed').val()
                }
            }
        }

        dataManagerA.setData(data);
        dataManagerA.send(gestEsitoAdd);
    }

});


/**
 * Click on table
 */

machineTable.on('click', 'td', function() {

    var data = machineTable.cell(this).index();
    var row = $(this).parents('tr');
    var addModMachine = $('#addModMachine');
    machineTable.$('tr.selected').removeClass('selected');
    addModMachine.hide();

    if (data.column == 7) {

        console.log("elimina");

        var rowData = machineTable.row(data.row).data();

        $("#idMachine").val(rowData[0]);
        $("#canDelete").val(0);
        $("#rowNum").val($(this).parents('tr').index());
        $('#confirmDeleteMachine').modal('show');

    } else if (data.column == 6) {

        var rowData = machineTable.row(data.row).data();
        var machine_name = $('#machine_name');
        var machine_description = $('#machine_description');
        var machine_drive_shaft = $('#machine_drive_shaft');
        var machine_max_speed = $('#machine_max_speed');
        var machine_curve_angle = $('#machine_curve_angle');
        var actionMod = $('#actionMod');
        var idMachine = $('#idMachine');
        row.addClass('selected');

        addModMachine.show();

        var rowData = machineTable.row(data.row).data();
        idMachine.val(rowData[0]);
        machine_name.val(rowData[1]);
        machine_description.val(rowData[2]);
        machine_drive_shaft.val(rowData[3]);
        machine_max_speed.val(rowData[4]);
        machine_curve_angle.val(rowData[5]);
        actionMod.val(1);
    }
});