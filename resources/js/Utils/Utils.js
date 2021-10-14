/**
 * Get a query param from the URI
 * @param name {String} - Query Parameter
 * @param defaultValue {*} - The default value in case it doesnt find
 * @returns {*}
 */
export function queryParam(name, defaultValue = null) {
    if (typeof window !== 'undefined') {
        let params = new URLSearchParams(window.location.search);
        let param = params.get(name);
        if (!param || param === '' || param === null || typeof param === 'undefined') {
            return defaultValue;
        }
        return param;
    }
    return defaultValue;
}

/**
 * Reset the page Query string and pushes the state
 */
export function queryReset() {
    if (typeof window !== 'undefined') {
        window.history.pushState({}, document.title, window.location.origin + window.location.pathname);
    }
}

/**
 * Limits or truncates a string
 * @param str {String} - The Original String
 * @param limit {Number} - The number of characters
 * @param endsOn {String} - Truncate with the following characters at the end
 * @returns {*}
 */
export function truncateString(str, limit = 10, endsOn = '...') {
    if (str.length <= limit) {
        return str
    }
    return str.slice(0, limit) + endsOn
}

/**
 * Returns the first entry of an object
 * @param obj {Object} - The Original String
 * @returns {Object}
 */
export function firstOf(obj) {
    return obj[Object.keys(obj)[0]];
}
