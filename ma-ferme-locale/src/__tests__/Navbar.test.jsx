import { cleanup, screen, render } from '@testing-library/react';
import { act } from 'react-dom/test-utils';
import Navbar from '../components/Navbar';

import Enzyme from 'enzyme';
import { mount, shallow } from 'enzyme';
import Adapter from '@wojtekmaj/enzyme-adapter-react-17';
import { Avatar, IconButton } from '@mui/material';
import Mobile from '../components/Navbar/Mobile';

Enzyme.configure({ adapter: new Adapter() });

describe('Navbar component', () => {

    it('The navbar should render', () => {
        expect(mount(<Navbar />)).toMatchSnapshot();
    });

    //the navbar should render good in mobile
    it('The navbar should render good in mobile', () => {
        expect(mount(<Mobile />)).toMatchSnapshot();
    });

    describe('Navbar render elements correctly', () => {

        let wrapper;

        beforeEach(() => {
            wrapper = shallow(<Navbar />);
        });

        afterEach(cleanup);

        it('The navbar should render the name', () => {
            expect(wrapper.findWhere(el => el.text() === 'MA FERME LOCALE')).toBeTruthy();
        });

        //the navbar should render an Avatar component with the alt 'lambda'
        it('The navbar should render the avatar', () => {
            expect(wrapper.containsMatchingElement(<Avatar />)).toBeTruthy();
        });

        //should render the good avatar if the user is not logged
        it('The navbar should render the good avatar if the user is not logged', () => {
            expect(wrapper.containsMatchingElement(<Avatar alt="lambda" />)).toBeTruthy();
        });

    });

    describe('Navbar render elements correctly on mobile', () => {

        let wrapper;

        beforeEach(() => {
            wrapper = shallow(<Mobile />);
        });

        afterEach(cleanup);

        //the navbar should have 4 icon buttons children
        it('The navbar should have 4 icon buttons children', () => {
            expect(wrapper.find(<IconButton />).length).toBe(5);
        });

    });

    afterEach(cleanup);

});

