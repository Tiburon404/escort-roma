/**
 * @namespace arcadia
 *
 */
(function() {
    var ns = escort;

    ns.dataManager = function (url, dataType){
        this._url=url;
        this._data=null;
        this._msgSuccess=null;
        this._dataType = dataType;
        this._result=null;
    };

    ns.dataManager.dataType={
        "JSON": 1,
        "FORM": 2
    };

    ns.dataManager.prototype.send=function(callback){

        let dataToSend=null;
        dataToSend=this._preapareData();

        $.ajax({
            url:this._url,
            type:"POST",
            data:dataToSend,
            contentType:"application/json;",
            dataType:"json",
            success: callback
        })

    };

    /**
     *
     * @param message
     */
    ns.dataManager.prototype.setSuccesseMsg=function(message){
        this._msgSuccess=message;
    };

    /**
     *
     * @param message
     */
    ns.dataManager.prototype.setFailureMsg=function(message){
        this._msgFailure=message;
    };

    /**
     *
     * @param data
     */
    ns.dataManager.prototype.setData=function(data){
        this._data=data;
    };


    ns.dataManager.prototype.setUrl=function(url){
        this._url=url;
    };


    /**
     *
     */
    ns.dataManager.prototype._preapareData=function(){
        return JSON.stringify(this._data);
    };


})();
