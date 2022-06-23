import { cleanup, render } from '@testing-library/react';
import AutocompleteBAN from '../components/Farm/Positions/AutocompleteBAN';
import Enzyme from 'enzyme';
import { mount, shallow } from 'enzyme';
import Adapter from '@wojtekmaj/enzyme-adapter-react-17';

Enzyme.configure({ adapter: new Adapter() });

describe('AutocompleteBAN components', () => {

    afterEach(cleanup);
    const onUseAutompleteMock = jest.fn();

    it('renders correctly', () => {
        expect(mount(<AutocompleteBAN />)).toMatchSnapshot();
    });

    describe('testing functionnality', () => {

        let wrapper;

        beforeEach(() => {
            wrapper = shallow(<AutocompleteBAN />);
        });

        it('should call onUseAutomplete when the user clicks on the button', () => {
            const wrapper = shallow(<AutocompleteBAN onUseAutomplete={onUseAutompleteMock} />);
            wrapper.find('button').simulate('click');
            expect(onUseAutompleteMock).toHaveBeenCalled();
        });

        it('It\'s different after click', () => {
            const { getByText } = render(<AutocompleteBAN />);
            getByText.find('input').simulate('click');
            expect(getByText).not.toMatchSnapshot();
        });

    });

});
