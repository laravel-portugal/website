import {usePage} from "@inertiajs/inertia-vue3";

/**
 * Get a query param from the URI
 * @param name {String} - Query Parameter
 * @param defaultValue {*} - The default value in case it doesnt find
 * @returns {*}
 */
export function queryParam(name, defaultValue = null) {
    if (notSSR()) {
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
 * Get all the quert params
 * @param merge {Object} - Filter and remove nulls and empty
 * @param filter {Boolean} - Filter and remove nulls and empty
 * @returns {Object}
 */
export function queryParams(merge = {},filter = true){
    let search = location.search.substring(1);

    // No search query return only the merge if any
    if(!search || search === ''){
        return merge
    }

    // Attempt to json parse
    let params = JSON.parse('{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}', function(key, value) { return key===""?value:decodeURIComponent(value) })

    // If we should filter
    if(filter){
        params = Object.fromEntries(Object.entries(params).filter(([_, v]) => v != null && v !== ''));
    }

    // Return both merged
    return {
        ...params,
        ...merge
    };
}

/**
 * Reset the page Query string and pushes the state
 */
export function queryReset() {
    if (notSSR()) {
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

export function notSSR() {
    return typeof window !== 'undefined' && typeof document !== 'undefined'
}

export function isSSR(){
    return typeof window === 'undefined' || typeof document === 'undefined'
}

/**
 * Resolves the assets path in a laravel way
 * @param path {String} - The Asset Path
 * @returns {String}
 */
export function asset(path){
    let prefix = process.env.MIX_ASSET_URL
    if (!prefix) {
        // fallback to determining ASSET_URL from Inertia Share
        // It should work for both Vapor & Regular Hosting
        prefix = usePage().props.value.meta.assets_url
    }
    return prefix + '/' + path.replace(/^\/+/, '')
}
