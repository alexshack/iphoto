String.prototype.replaceArray = function(find, replace) {
    var replaceString = this;
    for (var i = 0; i < find.length; i++) {
        replaceString = replaceString.replace(find[i], replace[i]);

    }
    return replaceString;
};

export const getUserName = (personalData , data = 'F I O') => {
    return data.replaceArray(
        ['F', 'I', 'O'],
        [
            personalData.last_name,
            personalData.first_name,
            personalData.middle_name
        ],
    );
};
