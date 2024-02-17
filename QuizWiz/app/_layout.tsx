import { Stack } from "expo-router";

const RootLayout = () => {
    /*Lo stack è un modo per navigare tra le pagine e sovrapporle quando si passa da una all'altra*/
    return <Stack>
        <Stack.Screen name='index' options={{
            headerTitle: "Home"
        }}/>
        <Stack.Screen name='login' options={{
            headerTitle: "LogIn"
        }}/>
    </Stack>;
};

export default RootLayout;