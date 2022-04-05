import React from 'react'
import ReactDOM from 'react-dom/client'
import './styles/app.css'
import Home from './components/Home'
import PropTypes from 'prop-types';

// const root = ReactDOM.createRoot(document.getElementById('root'))
// root.render(<Home />)

const myNews = [
    {
        id: 1,
        author: 'Саша Печкин',
        text: 'В четверг, четвертого числа...',
        bigText: 'в четыре с четвертью часа четыре чёрненьких чумазеньких чертёнка чертили чёрными чернилами чертёж.'
    },
    {
        id: 2,
        author: 'Просто Вася',
        text: 'Считаю, что $ должен стоить 35 рублей!',
        bigText: 'А евро 42!'
    },
    {
        id: 3,
        author: 'Max Frontend',
        text: 'Прошло 2 года с прошлых учебников, а $ так и не стоит 35',
        bigText: 'А евро опять выше 70.'
    },
    {
        id: 4,
        author: 'Гость',
        text: 'Бесплатно. Без смс, про реакт, заходи - https://maxpfrontend.ru',
        bigText: 'Еще есть группа VK, telegram и канал на youtube! Вся инфа на сайте, не реклама!'
    }
];

class Add extends React.Component {

    state = { // добавили начальное состояние
        name: '',
        text: '',
        agree: false,
        bigText: '', // добавлен bigText
    }

    onBtnClickHandler = (e) => {
        e.preventDefault()
        const { name, text, bigText } = this.state
        this.props.onAddNews({ id: +new Date(), author: name, text, bigText, })
        // alert(name + '\n' + text) // \n = перенос строки
    }

    handleNameChange = (e) => { //обработчик, в котором обновляем name
        this.setState({ name: e.currentTarget.value })
    }

    handleTextChange = (e) => { //обработчик, в котором обновляем text
        this.setState({ text: e.currentTarget.value })
    }

    handleChange = (e) => {
        const { id, value } = e.currentTarget
        this.setState({ [id]: e.currentTarget.value })
    }

    handleCheckboxChange = (e) => { // обработчик кликов по чекбоксу
        // чтобы установить true/false считываем свойство checked
      
        this.setState({ agree: e.currentTarget.checked })
    }

    validate = () => {
        const { name, text, agree } = this.state
        if (name.trim() && text.trim() && agree) {
            return true
        }
        return false
    }

    // constructor(props) {
    //     super(props)
    //     this.input = React.createRef()
    // }

    // componentDidMount() {
    //     // ставим фокус в input
    //     this.input.current.focus()
    // }

    // state = { myValue: '' }

    // onChangeHandler = (e) => {
    //     this.setState({ myValue: e.target.value })
    // }

    // onBtnClickHandler = (e) => {
    //     // alert(this.state.myValue);
    //     alert(this.input.current.value)
    // }

    // render() {
    //     return (
    //         <React.Fragment>
    //             <input
    //                 className='test-input'
    //                 onChange={this.onChangeHandler}
    //                 // value={this.state.myValue}
    //                 defaultValue=''
    //                 ref={this.input}
    //                 placeholder='введите значение' />
    //             <button onClick={this.onBtnClickHandler}>Показать alert</button>
    //         </React.Fragment>
    //     )
    // }

    render() {
        const { name, text, agree, bigText } = this.state

        return (
            <form className='add'>
                <input
                    id='name'
                    type='text'
                    onChange={this.handleChange}
                    className='add__author'
                    placeholder='Ваше имя'
                    value={name}
                />
                <textarea
                    id='text'
                    onChange={this.handleChange}
                    className='add__text'
                    placeholder='Текст новости'
                    value={text}
                ></textarea>
                <textarea
                    id='bigText'
                    onChange={this.handleChange}
                    className='add__text'
                    placeholder='Текст новости подробно'
                    value={bigText}
                ></textarea>
                <label className='add__checkrule'>
                    <input type='checkbox' onChange={this.handleCheckboxChange} /> Я согласен с правилами
                </label>
                <button
                    className='add__btn'
                    onClick={this.onBtnClickHandler}
                    disabled={!this.validate()}>
                        Показать alert
                </button>
            </form>
        )
    }
}

class App extends React.Component {

    state = {
        news: myNews, // в начальное состояние положили значение из переменной
    }

    handleAddNews = (data) => {
        // console.log('я вызвана из Add, но имею доступ к this.state у App!', this.state)
        const nextNews = [data, ...this.state.news]
        this.setState({ news: nextNews })
    }

    render() {
        return (
            <React.Fragment>
                <h3>Новости</h3>
                <Add onAddNews={this.handleAddNews}/>
                <News data={this.state.news}/>
            </React.Fragment>
        )
    }
}

class Article extends React.Component {
    state = {
        visible: false, // определили начальное состояние
    }

    handleReadMoreClck = (e) => { // добавили метод
        e.preventDefault()
        this.setState({ visible: true })
    }

    render() {
        const { author, text, bigText } = this.props.data
        const { visible } = this.state
        return (
            <div className="article">
                <p className="news__author">{author}:</p>
                <p className="news__text">{text}</p>
                { /* если не visible, то показывай */
                    !visible && <a onClick={this.handleReadMoreClck} href="#" className='news__readmore'>Подробнее</a>
                }
                { /* если visible, то показывай */
                    visible && <p className='news__big-text'>{bigText}</p>
                }
            </div>
        )
    }
}

class News extends React.Component {
    // удалили старое состояние counter: 0 (старый ненужный код)

    renderNews = () => {
        const { data } = this.props
        let newsTemplate = null
        if (data.length) {
            newsTemplate = data.map(function(item) {
                return <Article key={item.id} data={item}/>
            })
        } else {
            newsTemplate = <p>К сожалению новостей нет</p>
        }
        return newsTemplate
    }

    render() {
        const { data } = this.props // аналогично записи const data = this.props.data
        
        return (
            <div className="news">
                {this.renderNews()}
                {data.length ? <strong className={'news__count'}>Всего новостей: {data.length}</strong> : null}
            </div>
        );
    }
}

// добавили propTypes.
// propTypes (с маленькой буквы) = свойство News
News.propTypes = {
    data: PropTypes.array.isRequired // PropTypes (с большой буквы) = библиотека prop-types
}

Article.propTypes = {
    data: PropTypes.shape({
        id: PropTypes.number.isRequired,
        author: PropTypes.string.isRequired,
        text: PropTypes.string.isRequired,
        bigText: PropTypes.string.isRequired
    })
}

Add.propTypes = {
    onAddNews: PropTypes.func.isRequired, // func используется для проверки передачи function
}

const root = ReactDOM.createRoot(document.getElementById('root'))
root.render(<App />)