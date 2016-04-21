/**
 * 格式化字符串，形同C#的String.Format，示：{@code '<li>{0}</li>'.format('结算中');}
 * @return {String}
 */
String.prototype.format = function() {
    var args = arguments;
    if (args.length == 1 && typeof(args[0]) === 'object') {
        return this.replace(/\{([\w\d]+)\}/g, function(m, i) {
            return args[0][i];
        });
    } else {
        return this.replace(/\{(\d+)\}/g, function(m, i) {
            return args[i];
        });
    }
};