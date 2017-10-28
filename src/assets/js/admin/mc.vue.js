var app = new Vue({
    el: "#app",
    data: {
        module: '',
        routes: [],
        rows: 1,
        fields: [],
        relationshipsFields: [],
        formFields: []
    },
    methods: {
        generate: function () {

            var module = this.module.trim();

            if (!module.length) {
                return;
            }

            var that = this;
            return axios.get('/mc/generate/routes?module=' + module)
                .then(function (response) {
                    if (response.data.status) {
                        that.routes = response.data.routes;
                    }
                }).catch(function (error) {

                });
        },
        moduleFormSubmit: function (e) {
            e.preventDefault();
        },
        addRow: function (e) {
            e.preventDefault();
            this.rows = this.rows + 1;
        },
        fieldName: function (fieldName, field) {
            return field + "[" + fieldName + "]";
        },
        addRelationshipfield: function (fieldIndex) {
            var fields = this.relationshipsFields;
            var index = fields.indexOf(fieldIndex);

            if (index > -1) {
                fields.splice(index, 1);
            } else {
                fields.push(fieldIndex);
            }

            this.relationshipsFields = fields;
        },
        addFormfield: function (fieldIndex) {
            var fields = this.formFields;
            var index = fields.indexOf(fieldIndex);

            if (index > -1) {
                fields.splice(index, 1);
            } else {
                fields.push(fieldIndex);
            }

            this.formFields = fields;
        }
    }
});