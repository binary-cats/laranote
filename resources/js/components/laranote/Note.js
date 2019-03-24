import Model from './Model'

export default class Note extends Model {
    /**
     * Define the resource URL
     *
     * @return {string}
     */
    resource(){
        return 'notes'
    }
}
