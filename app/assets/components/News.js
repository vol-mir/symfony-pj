import React, {Component} from 'react';
import axios from 'axios';


class News extends Component {
    constructor() {
        super();
        
        this.state = { news: [], loading: true}
    }
    
    componentDidMount() {
        this.getNews();
    }
    
    getNews() {
        axios.get(`/api/news`).then(res => {
            const news = res.data.slice(0,15);
            this.setState({ news, loading: false })
        })
    }

    handleClick() {
        axios.post(`/api/download/rbc/news`).then(res => {
            this.getNews();
        })
    }

    render() {
        const loading = this.state.loading;
        return (
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <h2 className="text-center"><span>List of news</span><button type="button" className="btn btn-primary" onClick={() => this.handleClick()}>Download RBC</button></h2>
                        </div>
    
                        {loading ? (
                            <div className={'row text-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
    
                        ) : (
                            <div className={'row'}>
                                {this.state.news.map(post =>
                                    <div className="col-md-10 offset-md-1 row-block" key={post.id}>
                                        <ul id="sortable">
                                            <li>
                                                <div className="media">
                                                    <div className="media-body">
                                                        <h4>{post.title}</h4>
                                                        <p>{post.full_text.length < 150 ? `${post.full_text}` : `${post.full_text.substring(0, 150)}...`}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </section>
            </div>
        )
    }
}
    
export default News;