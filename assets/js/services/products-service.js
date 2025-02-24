import axios from 'axios';

/**
 * @param {string|null} categoryIri
 * @param {string|null} searchTerm
 * @returns {Promise}
 */
export function fetchProducts(categoryIri, searchTerm) {
    const params = {};
    if (categoryIri) {
        params.category = categoryIri;
    }

    if (searchTerm) {
        params.name = searchTerm;
    }

    return axios.get('/api/products', {
        params,
    });
}

/**
 * Gets a product from the API according to the IRI.
 *
 * @param {string} iri
 * @return {Promise}
 */
export function fetchOneProduct(iri) {
    return axios.get(iri);
}
