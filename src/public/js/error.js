/**
 * @namespace escort
 * @name error
 */
(function() {
    var ns = escort;

    /**
     *
     * @param errTitleId
     * @param errMessageId
     * @param errExtraInfoId
     * @param DialogBox
     */
    ns.error = function (errTitleId,errMessageId,errExtraInfoId,DialogBox){
        this._TitleId=$('#' + errTitleId);
        this._MessageId=$('#' + errMessageId);
        this._ExtraInfoId=$('#' + errExtraInfoId);
        this._DialogBox=$('#' + DialogBox);

        /**
         *
         * @type {{ERROR: number, INFO: number, SUCCESS: number}}
         */
        this.errorType={
            ERROR: 1,
            INFO: 2,
            SUCCESS: 3
        };

        /**
         *
         * @param title
         * @param message
         * @param extrainfo
         * @param errorType
         */
        this.showDialog=function(title,message,extrainfo,errorType){
            this._TitleId.text(title);
            this._MessageId.text(message);
            this._ExtraInfoId.text(extrainfo);
            var dialogRole= $('#escort_role');


            dialogRole.removeClass('alert-primary');
            dialogRole.removeClass('alert-danger');
            dialogRole.removeClass('alert-success');

            switch (errorType) {
                case this.errorType.ERROR:
                    dialogRole.addClass('alert-danger');
                    break;
                case this.errorType.INFO:
                    dialogRole.addClass('alert-primary');
                    break;
                case this.errorType.SUCCESS:
                    dialogRole.addClass('alert-success');
                    break;
                default:
                    dialogRole.addClass('alert-primary');
            }
            this._DialogBox.modal("show");

        };

    };

})();
